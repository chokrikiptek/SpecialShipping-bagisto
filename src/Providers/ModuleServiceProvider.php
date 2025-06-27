<?php

namespace Webkul\SpecialShipping\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Pas besoin d'enregistrer le carrier ici, il sera géré par la configuration
    }

    public function boot()
    {
        // Publier les configurations si nécessaire
        $this->publishes([
            dirname(__DIR__, 2) . '/config/system.php' => config_path('special_shipping.php'),
        ], 'special-shipping-config');
    }
}