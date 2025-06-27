<?php

return [
    [
        'key'    => 'sales.carriers.special_shipping',
        'name'   => 'Special Shipping',
        'sort'   => 1,
        'info'   => 'Configuration pour la livraison spéciale',
        'fields' => [
            [
                'name'    => 'active',
                'title'   => 'Actif',
                'type'    => 'boolean',
                'default' => true,
                'info'    => 'Activer ou désactiver cette méthode de livraison',
            ],
            [
                'name'    => 'title',
                'title'   => 'Titre',
                'type'    => 'text',
                'default' => 'Livraison Spéciale',
                'info'    => 'Titre affiché pour cette méthode de livraison',
            ],
            [
                'name'    => 'description',
                'title'   => 'Description',
                'type'    => 'text',
                'default' => 'Livraison gratuite si le montant minimum est atteint',
                'info'    => 'Description de la méthode de livraison',
            ],
            [
                'name'    => 'minimum_amount',
                'title'   => 'Montant Minimum',
                'type'    => 'text',
                'default' => '50',
                'info'    => 'Montant minimum pour activer la livraison gratuite',
            ],
            [
                'name'    => 'shipping_fee',
                'title'   => 'Frais de Livraison',
                'type'    => 'text',
                'default' => '10',
                'info'    => 'Frais de livraison appliqués si le montant minimum n\'est pas atteint',
            ],
        ],
    ],
];