<?php

namespace App\Models;

use App\Enums\ProductType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class Product
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property int $price
 * @property int $price_in_cents
 * @property string $product_image
 * @property int $product_category_id
 * @property ProductType $product_type
 * @property string $electronic_product_url
 * @property string $electronic_product_file_path
 * @property string $class_registration_url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property ProductCategory $product_category
 *
 * @package App\Models
 *
 */
class Product extends Model
{
	use SoftDeletes;

    protected $table = 'products';

	protected $casts = [
		'price' => 'int',
		'price_in_cents' => 'int',
		'product_category_id' => 'int',
		'product_type' => ProductType::class
	];

	protected $fillable = [
		'name',
		'slug',
		'description',
		'price',
		'price_in_cents',
		'product_image',
		'product_category_id',
        'product_type',
        'electronic_product_url',
        'electronic_product_file_path',
        'class_registration_url'
	];

    public function product_category()
	{
		return $this->belongsTo(ProductCategory::class);
	}

    public function orders()
    {
        return $this->hasManyThrough(Order::class, OrderProduct::class,
            'product_id', 'id', 'id', 'order_id');
    }

    public function getPriceInNaira($thousandSeparated = false) : string
    {
        if($thousandSeparated){
            return number_format($this->price/100, 2);
        }
        return moneyFormat($this->price / 100);
    }

    public function generateDownloadUrl($orderId, $uuid): string
    {
        if($this->class_registration_url){
            return $this->class_registration_url;
        } else {
            return route("customer.order.view", ['order' => $orderId]) . "?download={$uuid}";
        }
    }

    public function getOrderDownload($orderId)
    {
        return OrderDownload::where('order_id', $orderId)
            ->where('product_id', $this->id)
            ->latest()->first();
    }

    public static function encryptProductId($productId): string
    {
        // Encrypt the product ID
        $encryptedId = encryptDecrypt('encrypt', $productId);
        // Encode the encrypted ID to make it URL-friendly
        return urlencode(base64_encode($encryptedId));
    }

    public static function decryptProductId($encryptedProductId): string
    {
        // Decode the URL-safe encrypted ID
        $decodedEncryptedId = base64_decode(urldecode($encryptedProductId));
        // Decrypt the ID
        return encryptDecrypt('decrypt', $decodedEncryptedId);
    }
    const ELECTRONIC_PRODUCT_FOLDER = 'electronic_product_documents';
    public static function uploadProductDocument($fileInRequest, $productNameSlug)
    {
        if ($fileInRequest) {
            $filename = strtolower($productNameSlug) . time() . '.'
                . $fileInRequest->getClientOriginalExtension();
            return $fileInRequest->storeAs('/'. self::ELECTRONIC_PRODUCT_FOLDER, $filename, ['disk' => 'public']);
        }
        return null;
    }

    public function getProductDocumentFullPath(): string
    {
        if(!$this->electronic_product_file_path){
            return Storage::disk('public')
                ->path('/'. self::ELECTRONIC_PRODUCT_FOLDER . '/' . basename($this->electronic_product_url));
        }
        return Storage::disk('public')->path($this->electronic_product_file_path);
    }

    public function getProductDocumentMetadata(): array
    {
        $storageDisk = Storage::disk('public');
        $relativePath = $this->electronic_product_file_path;
        if(!$this->electronic_product_file_path){
            $relativePath = self::ELECTRONIC_PRODUCT_FOLDER . '/' . basename($this->electronic_product_url);
        }
        return [
            'mimeType' => $storageDisk->mimeType($relativePath),
            'size' => $storageDisk->size($relativePath),
            'path' => $relativePath,
            'fullPath' => $storageDisk->path($relativePath)
        ];
    }


}
