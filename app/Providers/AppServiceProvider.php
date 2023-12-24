<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
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
    }
}
