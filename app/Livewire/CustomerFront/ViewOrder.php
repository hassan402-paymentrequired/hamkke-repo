<?php

namespace App\Livewire\CustomerFront;

use App\Models\Order;
use App\Models\OrderDownload;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[Title('Order Details')]
#[Layout('livewire-layouts.customer-front-layout')]
class ViewOrder extends Component
{

    public Order $order;

    #[Url]
    public ?string $download = null;
    public ?array $downloadStatus = null;
    public ?bool $downloading;
    public ?OrderDownload $orderDownload;

    /**
     * @var Product[] $orderProducts
     */
    public array|Collection $orderProducts;

    /**
     * @param string|Order $order
     * @return void
     */
    public function mount(Order $order): void
    {
        $this->order = $order;
        $authUser = auth(CUSTOMER_GUARD_NAME)->user();
        $this->authorizeForUser($authUser,'access-order', $order)->allowed();
        $this->orderProducts = $this->order->products()->withTrashed()->get();
        if ($this->download) {
            $this->orderDownload = $order->order_downloads()->whereUuid($this->download)->first();
        }
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire-components.customer-front.view-order');
    }

    public function startDownload($productId = null)
    {
        try {
            if ($productId) {
                $this->orderDownload = $this->order->order_downloads()->where('product_id', $productId)
                    ->first();
            }
            $product = $this->orderDownload->product;
            $orderProduct = OrderProduct::where('order_id', $this->order->id)
                ->where('product_id', $product->id)->first();

            $downloadCount = $this->orderDownload->download_count;
            if (isProductionEnv() && $downloadCount > $orderProduct->quantity * 2) {
                $this->dispatch('show-toast', [
                    'title' => 'Oops!! Download Limit Exceeded!!',
                    'message' => 'This product has been downloaded 3 time already. <br>Thank you for your purchase',
                    'toast_type' => 'error'
                ]);
            } else {
                $fileMetadata = $this->orderDownload->product->getProductDocumentMetadata();
                $headers = [
                    'Content-Type' => $fileMetadata['mimeType'],
                    'Content-Length' => $fileMetadata['size'],
                ];
                $downloadCount += 1;
                $this->orderDownload->update([
                    'download_count' => $downloadCount,
                    'downloaded_at' => $downloadCount >= 2 ? now()->toDateTimeString() : null
                ]);
                return Storage::disk('public')->download($fileMetadata['path'], $fileMetadata['preferred_name'], $headers);
            }
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage() . "| File:: {$exception->getFile()} | Line:: {$exception->getLine()}");
            $this->dispatch('show-toast', [
                'title' => 'Download Failed!!',
                'message' => 'An error occurred, please contact admin for assistance',
                'toast_type' => 'error'
            ]);
        }

    }
}
