<?php

use App\Providers\RouteServiceProvider;
use Doctrine\DBAL\Schema\Index;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

function isProductionEnv(): bool
{
    return config('app.env') === 'production';
}

function isLocalOrDevOrTesting($env = null): bool
{
    if ($env) {
        return is_array($env) ? in_array(config('app.env'), $env) : (config('app.env') === $env);
    }

    return in_array(config('app.env'), ['local', 'develop', 'development', 'testing']);
}

function cleanupStringByRegexp($string, $regexp = "/[^a-zA-Z0-9\-\_ ]+/", $replacement = "", $toLowerCase = false): array|string|null
{
    $cleanedString = preg_replace($regexp, $replacement, $string);
    if ($toLowerCase) {
        return strtolower($cleanedString);
    }
    return $cleanedString;
}

function roundNumberUp($value): int
{
    return (int)round($value + 0.5, 0);
}

/**
 * @param string $searchString
 * @param array $columns
 * @return string
 */
function searchQueryConstructor($searchString, $columns): string
{
    $searchString = htmlentities($searchString);
    $searchWords = array_filter(explode(" ", trim($searchString)));
    if (count($searchWords) === 0) {
        return " 1 ";
    }
    $constructSqlArray = ["("];

    $initial = true;
    foreach ($columns as $columnName) {
        $constructSql = array_map(function ($word) use ($columnName, &$initial) {
            if ($initial) {
                $initial = false;
                return "$columnName LIKE '%{$word}%'";
            }
            return " OR $columnName LIKE '%{$word}%'";
        }, $searchWords);
        $constructSqlArray[] = implode($constructSql);
    }
    return implode($constructSqlArray) . ")";
}

/**
 * @param string $searchString
 * @param array $columns
 * @return string
 */
function orderByQueryConstructor(string $searchString, $columns): string
{
    $searchString = htmlentities($searchString);
    $searchWords = array_filter(explode(" ", trim($searchString)));
    $constructSqlArray = ["(CASE "];

    $orderNum = 1;
    foreach ($columns as $columnName) {

        $query = "WHEN {$columnName} LIKE '{$searchString}' THEN 1";
        $query .= " WHEN {$columnName} LIKE '{$searchString}%' THEN 2";
        $query .= " WHEN {$columnName} LIKE '%{$searchString}' THEN 4 ";

        $constructSqlArray[] = $query;

        $constructSql = array_map(function ($word) use ($columnName, &$orderNum) {
            $q = "WHEN {$columnName} LIKE '{$word}' THEN 1";
            $q .= " WHEN {$columnName} LIKE '{$word}%' THEN 2";
            $q .= " WHEN {$columnName} LIKE '%{$word}' THEN 4 ";
            return $q;
        }, $searchWords);
        $constructSqlArray[] = implode($constructSql);
        $orderNum++;
    }
    return implode($constructSqlArray) . "
            ELSE 3
        END)
    ";
}

function formatPhoneNumber($phoneNumber): array|string
{
    $phoneNumber = str_replace('/\+/', '', $phoneNumber);
    $countryCode = '234';
    if (strlen($phoneNumber) == 10 || strlen($phoneNumber) == 11) {
        $number = substr($phoneNumber, -10);
        $phoneNumber = '+' . $countryCode . $number;
    } elseif (strlen($phoneNumber) > 11) {
        $areaCode = substr($phoneNumber, 0, 3);
        if ($areaCode != $countryCode) {
            return $phoneNumber;
        }
        $phoneNumber = '+' . $phoneNumber;
    }

    return $phoneNumber;
}

/**
 * Verify the current route by name(s)
 * @param array|string $routeName
 * @return bool
 */
function isCurrentRoute(array|string $routeName): bool
{
    $currentRoute = Request::route()->getName();
    if (is_array($routeName)) {
        return in_array($currentRoute, $routeName);
    }
    return $currentRoute === $routeName;
}

/**
 * Verify the host
 * @param string|array domainName
 * @return bool
 */
function isCurrentDomain($domainName): bool
{
    $currentDomain = parse_url(request()->url(), PHP_URL_HOST);
    if (is_array($domainName)) {
        return in_array($currentDomain, $domainName);
    }
    return $currentDomain === $domainName;
}

function logCriticalError($message, Exception $actualException = null, $logChannel = null, $apiLogID = null): void
{
    $logChannel = $logChannel ?? config('logging.default');
    $logMessage = $errorMessage = $message;
    if ($actualException) {
        $errorMessage .= "\n
            ActualExceptionMessage:: {$actualException->getMessage()} \n
            File:: {$actualException->getFile()} \n
            Line:: {$actualException->getLine()}";

        $logMessage = $errorMessage . "\n
            Trace:: " . $actualException->getTraceAsString();
    }
    Log::channel($logChannel)->critical("Message :: " . $logMessage);
}

function logNonCriticalError($message, Exception $actualException = null, $logChannel = null): void
{
    $errorMessage = "Message :: {$message}";
    if ($actualException) {
        $errorMessage .= "\n
            ActualExceptionMessage:: {$actualException->getMessage()} \n
            File:: {$actualException->getFile()} \n
            Line:: {$actualException->getLine()} \n
            Trace:: {$actualException->getTraceAsString()}";
    }
    Log::channel($logChannel)->error($errorMessage);
}

/**
 * @param string $mailTo Recipient email address
 * @param string $mailerClass Full reference to the mailer class thar handles this mail
 * @param array $mailerClassParams Constructor parameters for the mailer class
 */
function sendMailWithMailerClass($mailTo, $mailerClass, $mailerClassParams, $multipleRecipient = null): void
{
    try {
        $mailer = Mail::to($mailTo);
        if($multipleRecipient){
            $mailer->cc($multipleRecipient);
        }
        $mailer->send(new $mailerClass(...$mailerClassParams));
    } catch (Exception $e) {
        Log::error("Error occurred while sending '{$mailerClass}' mail to '{$mailTo}'");
        Log::error($e);
    }
}

function removeSpecialCharacters($string)
{
    return str_replace('/[^A-Za-z0-9 ]/', '', $string);
}

function moneyFormat($value): string
{
    return sprintf('%01.2f', $value);
}

function arrayToCsv($data, $heading, $fileName): void
{
    $fp = fopen($fileName, 'w');
    if ($heading) {
        fputcsv($fp, $heading);
    }

    foreach ($data as $fields) {
        fputcsv($fp, $fields);
    }

    fclose($fp);
}

/**
 * @param $phoneNumber
 * @param bool $justStatus
 * @param null $regionCode
 * @return array|bool|mixed
 */
function validatePhoneNumber($phoneNumber, $justStatus = false, $regionCode = null)
{
    $invalidPhoneNumber = 'Invalid phone number';
    $errorResult = [
        'status' => false,
        'result' => $invalidPhoneNumber
    ];

    $phoneUtil = PhoneNumberUtil::getInstance();
    try {
        if(($regionCode === 'NG') || str_starts_with($phoneNumber, '+234')){
            $formattedPhone = cleanUpNigerianPhoneNumber($phoneNumber);
            if ($justStatus) {
                return !empty($formattedPhone);
            }
            return [
                'status' => !empty($formattedPhone),
                'result' => $formattedPhone ?? $invalidPhoneNumber
            ];
        }
        $phone = $phoneUtil->parse($phoneNumber, $regionCode);
        if ($justStatus) {
            return $phoneUtil->isValidNumber($phone);
        }
        if ($phoneUtil->isValidNumber($phone)) {
            $formattedPhone = $phoneUtil->format($phone, PhoneNumberFormat::E164);
            return [
                'status' => true,
                'result' => $formattedPhone
            ];
        }
        throw new NumberParseException(1, $invalidPhoneNumber);
    } catch (NumberParseException $e) {
        $errorResult['result'] = $e->getMessage();
    } catch (Exception $e) {
        $errorResult['result'] = $e->getMessage();
    }

    return ($justStatus) ? $errorResult['status'] : $errorResult;
}

function cleanUpNigerianPhoneNumber($phone): ?string
{
    return (strlen(trim(" " . $phone)) >= 10) ? "+234" . substr(trim($phone), -10) : null;
}

function generateUniqueRef($prefix, $uniqueID, $separator = '.')
{
    return $prefix . $uniqueID . $separator . strtoupper(uniqid());
}

/**
 * @param string $action
 * @param string $dataToEncrypt
 * @param $encryptMethod
 * @param $secretKey
 * @param $secretIV
 *
 * @return string
 */
function encryptDecrypt(string $action, string $dataToEncrypt, $encryptMethod = null, $secretKey = null, $secretIV = null): string
{
    if (empty($action) || !in_array($action, ['encrypt', 'decrypt'])) {
        throw new InvalidArgumentException('Invalid action provided. Action must be "encrypt" or "decrypt".');
    }

    if (empty($dataToEncrypt)) {
        throw new InvalidArgumentException('Data to encrypt/decrypt cannot be empty.');
    }

    $encryptMethod = $encryptMethod ?? config('app.cipher');
    $secretKey = $secretKey ?? config('app.enc_secret_key');
    $secretIV = $secretIV ?? config('app.enc_secret_iv');

    $key = hash('sha256', $secretKey);
    $iv = substr(hash('sha256', $secretIV), 0, 16);

    if ($action === 'encrypt') {
        $dataToEncrypt = is_array($dataToEncrypt) ? json_encode($dataToEncrypt) : $dataToEncrypt;
        $encryptedData = openssl_encrypt($dataToEncrypt, $encryptMethod, $key, OPENSSL_RAW_DATA, $iv);
        if ($encryptedData === false) {
            throw new \RuntimeException('Encryption failed.');
        }
        return base64_encode($encryptedData);
    } elseif ($action === 'decrypt') {
        $decodedData = base64_decode($dataToEncrypt);
        if ($decodedData === false) {
            throw new InvalidArgumentException('Invalid base64 data provided for decryption.');
        }
        $decryptedData = openssl_decrypt($decodedData, $encryptMethod, $key, OPENSSL_RAW_DATA, $iv);
        if ($decryptedData === false) {
            throw new \RuntimeException('Decryption failed.');
        }
        return $decryptedData;
    }

    throw new InvalidArgumentException('Invalid action provided. Action must be "encrypt" or "decrypt".');
}

/**
 * Generate the URL to a named route.
 *
 * @param  array|string $name
 * @param  mixed $parameters
 * @param  bool $absolute
 * @return string
 */
function routeByName($name, $parameters = [], $absolute = false): string
{
    return config('app.url') . route($name, $parameters, $absolute);
}

/**
 * @param \Illuminate\Http\Request $request
 * @param string $fieldName The name of the field in the request
 * @param string $storagePath Where do you want to store the file(s)
 * @param null $storeAsName Set this if you want the file to be stored as a particular name
 * @param bool|null $getAbsoluteUrl
 *
 * @return array|string|null An array of urls or a single url
 */
function uploadFilesFromRequest(\Illuminate\Http\Request $request, string $fieldName, string $storagePath, $storeAsName = null, ?bool $getAbsoluteUrl = true): array|string|null
{
    $fileNameToSet = cleanAlphanumericString($storeAsName);
    $documents = request($fieldName);
    if (is_array($documents)) {
        $uploadUrls = [];
        $path = null;
        if (!empty($documents)) {
            foreach ($documents as $file) {
                $filename = $fileNameToSet . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs($storagePath, $filename, ['disk' => 'public']);
                if($getAbsoluteUrl) {
                    $uploadUrls[] = getAbsoluteUrlFromPath($path);
                } else {
                    $uploadUrls[] = $path;
                }
            }
        }
        return $uploadUrls;
    }
    $file = $request->file($fieldName);
    if (!empty($file)) {
        $filename = $fileNameToSet . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($storagePath, $filename, ['disk' => 'public']);
        return $getAbsoluteUrl ? getAbsoluteUrlFromPath($path) : $path;
    }
    return null;
}

/**
 * @param $path
 * @return string
 */
function getAbsoluteUrlFromPath($path): string
{
    return asset(Storage::url($path));
}

function cleanAlphanumericString($subject): array|string|null
{
    return cleanupStringByRegexp(preg_replace('/[^a-zA-Z0-9\-\_ ]+/', '', $subject), '/ +/', "_", true);
}

function isImageFile($file): bool
{
    return str_starts_with($file->getMimeType(), 'image');

}

function flashErrorMessage($message): void
{
    Session::flash('error', $message);
}

function flashInfoMessage($message): void
{
    Session::flash('info', $message);
}

function flashSuccessMessage($message): void
{
    Session::flash('success', $message);
}

/**
 * @param string $tableName
 * @param callable|null $dataConversionFunction
 * @param array $columnsToExtract
 * @param int|null $limit
 * @param int|null $skip
 *
 * @return array
 */
function tableDataToJSON($tableName, $dataConversionFunction = null, $columnsToExtract = ['*'], $limit = null, $skip = null)
{
    $jsonPayload = [];
    $queryBuilder = DB::table($tableName)->select($columnsToExtract);
    if($limit){
        $queryBuilder->limit($limit);
    }
    if($skip){
        $queryBuilder->skip($skip);
    }
    $tableData = $queryBuilder->get();
    foreach ($tableData as $entry) {
        if($dataConversionFunction && is_callable($dataConversionFunction)) {
            $jsonPayload[] = $dataConversionFunction($entry);
        } else {
            $jsonPayload[] = (array)$entry;
        }
    }

    $newJsonString = json_encode($jsonPayload, JSON_PRETTY_PRINT);

    $timestamp = strtotime('now');
    $fileName = "tableDataToJSON_{$tableName}_{$timestamp}.json";
    file_put_contents(base_path("storage/app/public/{$fileName}"), stripslashes($newJsonString));

    return ['file_name' => $fileName, 'public_url' => asset(Storage::url($fileName))];
}

function getModelTableColumns($modelClassRef)
{
    $modelInstance = new  $modelClassRef();
    $table = $modelInstance->getTable();
    return getTableColumns($table);
}

function getTableColumns($tableName, $withDataType = false)
{
    $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
    if($withDataType){
        $columnsWithDataTypes = [];
        foreach ($columns as $columnName){

            $column = DB::connection()->getDoctrineColumn($tableName, $columnName);
            $columnsWithDataTypes[] = [
                'column' => $columnName,
                'dataType' => $column->getType()->getName(),
                'nullable' => !$column->getNotnull()
            ];
        }
        return $columnsWithDataTypes;
    }
    return $columns;
}

function listTableIndexes($tableName)
{
    return Schema::getConnection()->getDoctrineSchemaManager()->listTableIndexes($tableName);
}

/**
 * Splits a string by $maxLength of words
 *
 * @param $stringToBeSplit
 * @param int $wordsInEachPart
 * @return array
 */
function splitByWords($stringToBeSplit, $wordsInEachPart)
{
    // explode the text into an array of words
    $wordsArray = explode(' ', $stringToBeSplit);

    if(str_word_count($stringToBeSplit) > $wordsInEachPart) {
        $parts = array_chunk($wordsArray, $wordsInEachPart);

        $splitStringArray = array_map(function ($part) {
            return implode(" ", $part);
        }, $parts);
    } else {
        $splitStringArray = [$stringToBeSplit];
    }

    return $splitStringArray;
}

/**
 * @param string $stringToCheck
 * @return boolean
 */
function isJson(string $stringToCheck): bool
{
    if(is_string($stringToCheck) && !is_numeric($stringToCheck)){
        json_decode($stringToCheck);
        return json_last_error() === JSON_ERROR_NONE;
    }
    return false;
}

/**
 * @param $tableName
 * @return Index[]
 */
function getTableIndexes($tableName): array
{
    $sm = Schema::getConnection()->getDoctrineSchemaManager();
    return $sm->listTableIndexes($tableName);
}

function getJsonFileContent($filePath, $defaultResponse = null){
    if(file_exists(base_path($filePath))) {
        return json_decode(
            file_get_contents(base_path($filePath)), true
        );
    } else {
        return $defaultResponse;
    }
}

function populateJsonFileContent($filePath, $content): bool
{
    $newJsonString = json_encode($content, JSON_PRETTY_PRINT);
    $result = file_put_contents(
        base_path($filePath),
        stripslashes($newJsonString)
    );
    return $result && $result > 0;
}

/**
 * @param float $numberToFormat <p>
 * The number being formatted.
 * </p>
 * @param int $decimalPlaced [optional] <p>
 * Sets the number of decimal points.
 * </p>
 * @return string
 */
function numberFormatWithoutComma(float $numberToFormat, int $decimalPlaced = 2): string
{
    return number_format($numberToFormat, $decimalPlaced, '.', '');
}

function getMonthsInYear(): array
{
    return [
        ['month' => 1, 'name' => 'January', 'amount' => 0],
        ['month' => 2, 'name' => 'February', 'amount' => 0],
        ['month' => 3, 'name' => 'March', 'amount' => 0],
        ['month' => 4, 'name' => 'April', 'amount' => 0],
        ['month' => 5, 'name' => 'May', 'amount' => 0],
        ['month' => 6, 'name' => 'June', 'amount' => 0],
        ['month' => 7, 'name' => 'July', 'amount' => 0],
        ['month' => 8, 'name' => 'August', 'amount' => 0],
        ['month' => 9, 'name' => 'September', 'amount' => 0],
        ['month' => 10, 'name' => 'October', 'amount' => 0],
        ['month' => 11, 'name' => 'November', 'amount' => 0],
        ['month' => 12, 'name' => 'December', 'amount' => 0],
    ];
}

function assetWithVersion($path, $secure = false): string
{
    $secure = !$secure ? request()->secure() : $secure;
    $assetVersion = (isProductionEnv()) ? config('app.asset_version') : uniqid('av');
    return asset( "$path?ver=$assetVersion" , $secure);
}

function convertRequestToQueryString(): string
{
    $queryString = http_build_query(request()->all());
    return rtrim($queryString, '&');
}

function sanitizeQueryString(): void // Remove 'amp;' attached to the query params for reasons unidentified yet
{
    foreach(request()->all() as $key => $val){
        $newKey = str_replace('amp;', '', $key);
        request()->merge([ $newKey => $val ]);
    }
}

/**
 * Get the bearer token from the request headers.
 *
 * @return string|null
 */
function getRequestBearerToken(\Illuminate\Http\Request $request): ?string
{
    $header = $request->header('Authorization', '');
    if (Str::startsWith($header, ['Bearer ', 'bearer '])) {
        return Str::substr($header, 7);
    }
    return null;
}

function calculatePaginationSkip(int $sizePerPage, $currentPage = 1): float|int
{
    return ($sizePerPage * $currentPage) - $sizePerPage ;
}

function appStoragePath($fileName = ''): string
{
    return Storage::path($fileName);
}

/**
 * @param string $subject
 * @param string $message
 * @param bool $error
 * @return void
 */
function developerDebugLogger(string $subject, string $message, bool $error = false): void
{
    if(config('developer_helpers.debug_external_apilogs')){
        $logger = Log::channel('developer_debugging');
        if($error){
            $logger->critical("{$subject} ~ " . $message);
        } else {
            $logger->info("{$subject} ~ " . $message);
        }
    }
}

function getAmountInKobo($amountInNaira): float|int
{
    return $amountInNaira * 100;
}

function getFileSize($filePath): float|int
{
    $sizeInBytes = File::size($filePath);
    return $sizeInBytes * pow(10, -6); // Convert size to Megabytes(MB)
}

function getCorrectAbsolutePath($assetUrl): array|string|null
{

    $path = preg_replace('/^http.*\/storage\//', '', $assetUrl);
    if(!str_starts_with($path,'http')) {
        return getAbsoluteUrlFromPath($path);
    }
    return $path;

}

/**
 * @return bool
 */
function customerIsLoggedIn() : bool
{
    return auth(CUSTOMER_GUARD_NAME)->check();
}

/**
 * @param string $htmlContent
 * @param int $wordsPerMinute
 * @return string
 */
function calculateReadingTime(string $htmlContent, int $wordsPerMinute = 200): string
{
    // Strip HTML tags and extract text content
    $textContent = strip_tags($htmlContent);

    // Count the number of words
    $wordCount = str_word_count($textContent);

    // Calculate reading time in minutes
    $readingTime = ceil($wordCount / $wordsPerMinute);
    return "$readingTime" . Str::plural('min', $readingTime);
}

if (!function_exists('assetWithVersion')) {
    function assetWithVersion($path, $version = null): string
    {
        // Append version query parameter to asset URL
        $url = asset($path);
        $defaultVersion = isLocalOrDevOrTesting() ? time() : config('app.asset_version');
        $version = $version ?: $defaultVersion;
        $url .= '?v=' . urlencode($version);
        return $url;
    }
}

/**
 * @return Authenticatable|null
 */
function getAuthUserPrioritizeCustomer() : Authenticatable|null
{
    $adminLoggedIn = auth()->check();
    $customerLoggedIn = auth(CUSTOMER_GUARD_NAME)->check();
    if(!$adminLoggedIn && !$customerLoggedIn){
        return  null;
    }
    if($customerLoggedIn){
        return auth(CUSTOMER_GUARD_NAME)->user();
    }
    return auth()->user();
}

function isAdminRoute(): bool
{
    $currentPath = request()->path();
    return str_starts_with($currentPath, 'admin');
}

function redirectUserHome(): string
{
    return isAdminRoute() ? url(RouteServiceProvider::ADMIN_HOME) : url(RouteServiceProvider::HOME);
}

function includeWWWPrefix($domain)
{
    $current = request()->getHost();
    $currentDomainHasWWW = str_starts_with($current, 'www.');
    if(!str_starts_with($domain, 'www.') && $currentDomainHasWWW) {
        return "www.{$domain}";
    }
    return $domain;
}

function currentRouteIsPermissionProtected(\Illuminate\Http\Request $request): bool
{
    /**
     * @var Route $route
     */
    $route = $request->route();
    return in_array('permission_protected', $route->middleware())
        && in_array('auth', $route->middleware())
        && str_starts_with($route->getName(), 'admin.');
}

/**
 * @param $text
 * @return string
 */
function createSlugFromString($text): string
{
    return Str::slug($text);
}
