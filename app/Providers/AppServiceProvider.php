<?php

namespace App\Providers;

use App\Helpers\SiteSettings;
use App\Models\Permission;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Sanctum::ignoreMigrations();
        $this->app->singleton('hamkke-cart', function ($app) {
            return new CartService();
        });
        $this->app->singleton('hamkke-payment', function ($app) {
            return new PaymentService();
        });
        $this->app->singleton('hamkke-order', function ($app) {
            return new OrderService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(CartService $cartService): void
    {
        Paginator::defaultView('vendor/pagination/bootstrap-5');
        Blade::directive('form_field_error', function ($formFieldName) {
            return "<?php if (\$errors->has({$formFieldName})): ?>
                <span class=\"help-block form-error\"  role=\"alert\">
                    <?php echo \$errors->first({$formFieldName}); ?>
                </span>
            <?php endif; ?>";
        });
        Blade::directive('old_selected', function ($expression) {
            $arguments = explode(',', $expression);
            $formFieldName = $arguments[0];
            $optionValue = $arguments[1];
            $optionText = !empty($arguments[2]) ? $arguments[2] : $optionValue;
            return "<option value={$optionValue}" . (old($formFieldName) == $optionValue ? 'selected' : '') . ">{$optionText}</option>";
        });

        view()->composer('*', function(View $view) {
            $view->with('authUser', Auth::user())
                ->with('allPermissions', Permission::all())
                ->with('customerAuthUser', Auth::guard(CUSTOMER_GUARD_NAME)->user())
                ->with('coreSiteDetails', new SiteSettings());
        });

        view()->composer('layouts.frontend.front-app', function ($view) use ($cartService) {
            $cartItemCount = $cartService->getCartItemCount(); // Implement this method in your CartService
            $view->with('cartItemCount', $cartItemCount);
        });
    }
}
