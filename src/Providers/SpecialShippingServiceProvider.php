<?php

namespace Webkul\SpecialShipping\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Webkul\SpecialShipping\Carriers\SpecialShipping;

class SpecialShippingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(\Webkul\SpecialShipping\Providers\ModuleServiceProvider::class);
    }

    public function boot()
    {
        \Log::info('SpecialShipping: ServiceProvider boot() appelé');
        
        $this->loadConfigs();
        $this->registerCarrier();
    }

    protected function loadConfigs()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__, 2) . '/config/system.php', 'core'
        );
        \Log::info('SpecialShipping: Configuration chargée');
    }

    protected function registerCarrier()
    {
        // Enregistrer le carrier dans la configuration de Bagisto
        $carriers = config('carriers', []);
        
        $carriers['special_shipping'] = [
            'code'         => 'special_shipping',
            'title'        => 'Special Shipping',
            'description'  => 'Special Shipping Method',
            'active'       => true,
            'default_rate' => '0',
            'class'        => 'Webkul\SpecialShipping\Carriers\SpecialShipping',
        ];

        config(['carriers' => $carriers]);
        
        \Log::info('SpecialShipping: Carrier enregistré dans la config', [
            'carriers_count' => count($carriers),
            'special_shipping_exists' => isset($carriers['special_shipping'])
        ]);
    }
}