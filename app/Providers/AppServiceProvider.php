<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 *
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);


        Blade::directive('checking', function ($expression) {

            if (auth()->guard('admin')->check()) {
                return "<?php if (app('laratrust')->can({$expression})): ?>";
            } else {
                return('<?php if (isset($_can[explode("-", ' . $expression . ')[0]]) && $_can[explode("-", ' . $expression . ')[0]]): ?>');
            }
        });

        Blade::directive('endchecking', function () {
            return "<?php endif; ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app->alias('bugsnag.logger', \Psr\Log\LoggerInterface::class);
//        $this->app->alias('bugsnag.logger', \Psr\Log\LoggerInterface::class);
    }
}
