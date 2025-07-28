<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;

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
        // Tambahkan direktif Blade custom untuk format rupiah
        Blade::directive('rupiah', function ($expression) {
            return "<?php echo 'Rp ' . number_format($expression, 0, ',', '.'); ?>";
        });

        // Paksa penggunaan HTTPS di semua route jika bukan di lokal
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }
    }
}
