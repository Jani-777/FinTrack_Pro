<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade; // Import this!

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // We create a custom Blade directive called @money
        Blade::directive('money', function ($expression) {
            return "<?php 
                \$val = (float) $expression;
                if (\$val >= 1000000000) {
                    echo '₱' . number_format(\$val / 1000000000, 2) . 'B';
                } elseif (\$val >= 1000000) {
                    echo '₱' . number_format(\$val / 1000000, 2) . 'M';
                } else {
                    echo '₱' . number_format(\$val, 2);
                }
            ?>";
        });
    }
}