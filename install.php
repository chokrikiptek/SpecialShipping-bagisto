<?php

/**
 * Script d'installation pour SpecialShipping
 */

// Vérifier que nous sommes dans un environnement Laravel
if (! defined('LARAVEL_START')) {
    require_once __DIR__ . '/../../../vendor/autoload.php';
    
    $app = require_once __DIR__ . '/../../../bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
}

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    // Vérifier si la configuration existe déjà
    $configExists = DB::table('core_config')
        ->where('code', 'sales.carriers.special_shipping.active')
        ->exists();

    if (! $configExists) {
        // Insérer les configurations par défaut
        $configs = [
            [
                'code' => 'sales.carriers.special_shipping.active',
                'value' => '1',
            ],
            [
                'code' => 'sales.carriers.special_shipping.title',
                'value' => 'Livraison Spéciale',
            ],
            [
                'code' => 'sales.carriers.special_shipping.description',
                'value' => 'Livraison gratuite si le montant minimum est atteint',
            ],
            [
                'code' => 'sales.carriers.special_shipping.minimum_amount',
                'value' => '50',
            ],
            [
                'code' => 'sales.carriers.special_shipping.shipping_fee',
                'value' => '10',
            ],
        ];

        foreach ($configs as $config) {
            DB::table('core_config')->insert($config);
        }

        echo "Configuration SpecialShipping installée avec succès!\n";
    } else {
        // Vérifier si le nouveau champ shipping_fee existe
        $shippingFeeExists = DB::table('core_config')
            ->where('code', 'sales.carriers.special_shipping.shipping_fee')
            ->exists();

        if (! $shippingFeeExists) {
            DB::table('core_config')->insert([
                'code' => 'sales.carriers.special_shipping.shipping_fee',
                'value' => '10',
            ]);
            echo "Nouveau champ shipping_fee ajouté!\n";
        } else {
            echo "Configuration SpecialShipping existe déjà.\n";
        }
    }

    // Vider le cache de configuration
    if (function_exists('artisan')) {
        \Artisan::call('config:clear');
        \Artisan::call('cache:clear');
        echo "Cache vidé avec succès!\n";
    }

} catch (Exception $e) {
    echo "Erreur lors de l'installation: " . $e->getMessage() . "\n";
} 