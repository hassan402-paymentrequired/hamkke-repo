<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

function isProductionEnv()
{
    return config('app.env') === 'production';
}

function isLocalOrDevOrTesting($env = null)
{
    if ($env) {
        return is_array($env) ? in_array(config('app.env'), $env) : (config('app.env') === $env);
    }

    return in_array(config('app.env'), ['local', 'develop', 'development', 'testing']);
}

function cleanupStringByRegexp($string, $regexp = "/[^a-zA-Z0-9\-\_ ]+/", $replacement = "", $toLowerCase = false)
{
    $cleanedString = preg_replace($regexp, $replacement, $string);
    if ($toLowerCase) {
        return strtolower($cleanedString);
    }
    return $cleanedString;
}

function roundNumberUp($value)
{
    return (int)round($value + 0.5, 0);
}

/**
 * @param string $searchString
 * @param array $columns
 * @return string
 */
function searchQueryConstructor($searchString, $columns)
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
function orderByQueryConstructor($searchString, $columns)
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

function formatPhoneNumber($phoneNumber)
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
 * @param string|array $routeName
 * @return bool
 */
function isCurrentRoute($routeName)
{
    $currentRoute = Request::route()->getName();
    if (is_array($routeName)) {
        return in_array($currentRoute, $routeName);
    }
    return $currentRoute === $routeName;
}

function logCriticalError($message, Exception $actualException = null, $logChannel = null, $apiLogID = null)
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
    if (in_array(config('app.env'), ['staging', 'production']) && !in_array($logChannel,['cron_tasks_logs', 'external_api_requests'])) {
        Log::channel('slack')->critical($errorMessage);
    }
    Log::channel($logChannel)->critical("Message :: " . $logMessage);
}

function logNonCriticalError($message, Exception $actualException = null, $logChannel = null)
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
function sendMailWithMailerClass($mailTo, $mailerClass, $mailerClassParams, $multipleRecipient = null)
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

function moneyFormat($value)
{

    return sprintf('%01.2f', $value);
}

function arrayToCsv($data, $heading, $fileName)
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

    $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
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
            $formattedPhone = $phoneUtil->format($phone, \libphonenumber\PhoneNumberFormat::E164);
            return [
                'status' => true,
                'result' => $formattedPhone
            ];
        }
        throw new \libphonenumber\NumberParseException(1, $invalidPhoneNumber);
    } catch (\libphonenumber\NumberParseException $e) {
        $errorResult['result'] = $e->getMessage();
    } catch (\Exception $e) {
        $errorResult['result'] = $e->getMessage();
    }

    return ($justStatus) ? $errorResult['status'] : $errorResult;
}

function cleanUpNigerianPhoneNumber($phone)
{
    return (strlen(trim(" " . $phone)) >= 10) ? "+234" . substr(trim($phone), -10) : null;
}

function generateUniqueRef($prefix, $uniqueID, $separator = '.')
{
    return $prefix . $uniqueID . $separator . strtoupper(uniqid());
}

function encryptDecrypt($action, $dataToEncrypt, $encryptMethod = null, $secretKey = null, $secretIV = null)
{
    $output = false;

    $encryptMethod = $encryptMethod ?? config('app.cipher');
    $secretKey = $secretKey ?? config('app.enc_secret_key');
    $secret_iv = $secretIV ?? config('app.enc_secret_iv');

    // hash
    $key = hash('sha256', $secretKey);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ($action == 'encrypt') {
        if(is_array($dataToEncrypt)){
            $dataToEncrypt = json_encode($dataToEncrypt);
        }
        $output = openssl_encrypt($dataToEncrypt, $encryptMethod, $key, OPENSSL_RAW_DATA, $iv);
        $output = base64_encode($output);
    } elseif ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($dataToEncrypt), $encryptMethod, $key, OPENSSL_RAW_DATA, $iv);
    }

    return $output;
}

/**
 * Generate the URL to a named route.
 *
 * @param  array|string $name
 * @param  mixed $parameters
 * @param  bool $absolute
 * @return string
 */
function routeByName($name, $parameters = [], $absolute = false)
{
    return config('app.url') . route($name, $parameters, $absolute);
}

/**
 * @param \Illuminate\Http\Request $request
 * @param string $fieldName The name of the field in the request
 * @param string $storagePath Where do you want to store the file(s)
 * @param null $storeAsName Set this if you want the file to be stored as a particular name
 *
 * @return array|string An array of urls or a single url
 */
function uploadFilesFromRequest(\Illuminate\Http\Request $request, $fieldName, $storagePath, $storeAsName = null)
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
                array_push($uploadUrls, asset(Storage::url($path)));
            }
        }
        return $uploadUrls;
    }
    $file = $request->file($fieldName);
    if (!empty($file)) {
        $filename = $fileNameToSet . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($storagePath, $filename, ['disk' => 'public']);
        return asset(Storage::url($path));
    }
}

function cleanAlphanumericString($subject)
{
    return cleanupStringByRegexp(preg_replace('/[^a-zA-Z0-9\-\_ ]+/', '', $subject), '/ +/', "_", true);
}

function isImageFile($file)
{
    return substr($file->getMimeType(), 0, 5) === 'image';

}

function flashErrorMessage($message)
{
    Session::flash('error', $message);
}

function flashInfoMessage($message)
{
    Session::flash('info', $message);
}

function flashSuccessMessage($message)
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
    $queryBuilder = \Illuminate\Support\Facades\DB::table($tableName)->select($columnsToExtract);
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
function isJson($stringToCheck)
{
    if(is_string($stringToCheck) && !is_numeric($stringToCheck)){
        json_decode($stringToCheck);
        return json_last_error() === JSON_ERROR_NONE;
    }
    return false;
}

/**
 * @param $tableName
 * @return \Doctrine\DBAL\Schema\Index[]
 */
function getTableIndexes($tableName){
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

function populateJsonFileContent($filePath, $content){
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
function numberFormatWithoutComma($numberToFormat, $decimalPlaced = 2)
{
    return number_format($numberToFormat, $decimalPlaced, '.', '');
}

function getMonthsInYear(){
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

function assetWithVersion($path, $secure = false)
{
    $secure = !$secure ? request()->secure() : $secure;
    $assetVersion = (isProductionEnv()) ? config('app.asset_version') : uniqid('av');
    return asset( "$path?ver=$assetVersion" , $secure);
}

function convertRequestToQueryString()
{
    $queryString = http_build_query(request()->all());
    return rtrim($queryString, '&');
}

function sanitizeQueryString() // Remove 'amp;' attached to the query params for reasons unidentified yet
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
function getRequestBearerToken(\Illuminate\Http\Request $request)
{
    $header = $request->header('Authorization', '');
    if (\Illuminate\Support\Str::startsWith($header, ['Bearer ', 'bearer '])) {
        return \Illuminate\Support\Str::substr($header, 7);
    }
    return null;
}

function calculatePaginationSkip(int $sizePerPage, $currentPage = 1){
    return ($sizePerPage * $currentPage) - $sizePerPage ;
}

function appStoragePath($fileName = ''){
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

function getAmountInKobo($amountInNaira)
{
    return $amountInNaira * 100;
}

function getFileSize($filePath)
{
    $sizeInBytes = File::size($filePath);
    return $sizeInBytes * pow(10, -6); // Convert size to Megabytes(MB)
}
