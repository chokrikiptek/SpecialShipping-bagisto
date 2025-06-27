<?php

namespace Webkul\SpecialShipping\Carriers;

use Webkul\Checkout\Facades\Cart;
use Webkul\Checkout\Models\CartShippingRate;
use Webkul\Shipping\Carriers\AbstractShipping;

class SpecialShipping extends AbstractShipping
{
    protected $code = 'special_shipping';
    protected $method = 'special_shipping_special_shipping';

    public function calculate()
    {
        \Log::info('SpecialShipping: calculate() appelé');
        
        try {
            if (! $this->isAvailable()) {
                \Log::info('SpecialShipping: isAvailable() retourne false');
                return false;
            }

            $cart = Cart::getCart();
            \Log::info('SpecialShipping: Cart récupéré', [
                'cart_exists' => $cart ? 'oui' : 'non',
                'items_count' => $cart ? $cart->items_count : 0,
                'grand_total' => $cart ? $cart->grand_total : 0,
                'shipping_address' => $cart && $cart->shipping_address ? 'oui' : 'non'
            ]);
            
            if (! $cart || ! $cart->items_count) {
                \Log::info('SpecialShipping: Panier vide ou pas d\'articles');
                return false;
            }

            // Vérifier si une adresse de livraison existe
            if (! $cart->shipping_address) {
                \Log::info('SpecialShipping: Pas d\'adresse de livraison');
                return false;
            }

            $minAmount = (float) $this->getConfigData('minimum_amount') ?? 50;
            $shippingFee = (float) $this->getConfigData('shipping_fee') ?? 10;
            
            \Log::info('SpecialShipping: Configuration', [
                'min_amount' => $minAmount, 
                'cart_total' => $cart->grand_total,
                'shipping_fee' => $shippingFee
            ]);

            // Calculer les frais de livraison
            $finalShippingFee = 0;
            if ($cart->grand_total < $minAmount) {
                $finalShippingFee = $shippingFee;
                \Log::info('SpecialShipping: Frais appliqués car montant insuffisant', ['fee' => $finalShippingFee]);
            } else {
                \Log::info('SpecialShipping: Livraison gratuite car montant suffisant');
            }

            $carrierTitle = $this->getConfigData('title') ?? 'Livraison Spéciale';
            $carrierDesc = $this->getConfigData('description') ?? 'Livraison gratuite si le montant minimum est atteint';

            $shippingRate = new CartShippingRate;

            $shippingRate->carrier = $this->code;
            $shippingRate->carrier_title = $carrierTitle;
            $shippingRate->method = $this->method;
            $shippingRate->method_title = $carrierTitle;
            $shippingRate->method_description = $carrierDesc;
            $shippingRate->price = $finalShippingFee;
            $shippingRate->base_price = $finalShippingFee;

            \Log::info('SpecialShipping: Rate créé avec succès', [
                'carrier' => $shippingRate->carrier,
                'method' => $shippingRate->method,
                'price' => $shippingRate->price
            ]);

            return $shippingRate;
        } catch (\Exception $e) {
            \Log::error('SpecialShipping calculate error: ' . $e->getMessage());
            return false;
        }
    }

    public function isAvailable()
    {
        \Log::info('SpecialShipping: isAvailable() appelé');
        
        try {
            $isActive = (bool) $this->getConfigData('active');
            \Log::info('SpecialShipping: Config active', ['active' => $isActive]);
            
            if (! $isActive) {
                \Log::info('SpecialShipping: Plugin désactivé');
                return false;
            }

            // Ne vérifier que la configuration, pas le panier ou l'adresse
            // Ces vérifications seront faites dans calculate()
            \Log::info('SpecialShipping: isAvailable() retourne true');
            return true;
        } catch (\Exception $e) {
            \Log::error('SpecialShipping isAvailable error: ' . $e->getMessage());
            return false;
        }
    }

    public function getConfigData($field)
    {
        $value = core()->getConfigData('sales.carriers.special_shipping.' . $field);
        \Log::info('SpecialShipping: getConfigData', ['field' => $field, 'value' => $value]);
        return $value;
    }
}