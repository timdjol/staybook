<?php

namespace App\Providers;

use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application amenities.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application amenities.
     */
    public function boot(): void
    {
        Blade::directive('routeactive', function ($route) {
            return "<?php echo Route::currentRouteNamed($route) ? 'class=\"current\"' : ''  ?>";
        });
        Blade::if('hotel', function () {
            Auth::user()->hasRole('Hotel');
        });
        Blade::if('admin', function () {
            return Auth::user()->hasRole('Super Admin');
        });
        Blade::if('manager', function () {
            return Auth::user()->hasRole('Manager');
        });
        Blade::if('buh', function () {
            return Auth::user()->hasRole('Accoundate');
        });


        Scramble::configure()
            ->withDocumentTransformers(function (OpenApi $openApi) {
                $openApi->secure(
                    SecurityScheme::http('bearer')
                );
            });

    }
}
