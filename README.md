# SpecialShipping - Plugin de livraison spéciale pour Bagisto

## Description
Plugin de livraison gratuite conditionnelle pour Bagisto. Offre la livraison gratuite lorsque le montant minimum du panier est atteint.

## Problèmes résolus
- ✅ Le plugin apparaît maintenant en frontend
- ✅ N'interfère plus avec les méthodes de livraison standard
- ✅ Permet de passer au paiement après sélection de la méthode
- ✅ Compatible avec l'architecture de Bagisto

## Installation

### 1. Installation automatique
```bash
cd /path/to/your/bagisto
php packages/Webkul/SpecialShipping/install.php
```

### 2. Installation manuelle
```bash
# Vider les caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Recharger l'autoloader
composer dump-autoload
```

### 3. Configuration dans l'admin
1. Allez dans l'admin de Bagisto
2. Naviguez vers **Configuration > Ventes > Méthodes de livraison**
3. Trouvez **"Special Shipping"** et cliquez sur **"Configurer"**
4. Activez la méthode et configurez :
   - **Titre** : "Livraison Spéciale"
   - **Description** : "Livraison gratuite si le montant minimum est atteint"
   - **Montant Minimum** : 50 (ou votre montant souhaité)

## Test du plugin

### Test automatique
```bash
php packages/Webkul/SpecialShipping/test-shipping.php
```

### Test manuel
1. Ajoutez des produits au panier
2. Allez au checkout
3. Remplissez l'adresse de livraison
4. Vérifiez que "Livraison Spéciale" apparaît dans les options
5. Sélectionnez la méthode et vérifiez que vous pouvez passer au paiement

## Fonctionnalités

### Conditions d'activation
- ✅ Plugin activé dans l'admin
- ✅ Panier non vide
- ✅ Adresse de livraison renseignée
- ✅ Montant du panier ≥ montant minimum configuré

### Comportement
- 🆓 Livraison gratuite (0€) si les conditions sont remplies
- ❌ Non disponible si les conditions ne sont pas remplies
- 🔄 Compatible avec les autres méthodes de livraison

## Structure du package

```
packages/Webkul/SpecialShipping/
├── src/
│   ├── Carriers/
│   │   └── SpecialShipping.php          # Logique du carrier
│   └── Providers/
│       ├── SpecialShippingServiceProvider.php  # Enregistrement du carrier
│       └── ModuleServiceProvider.php    # Configuration du module
├── config/
│   └── system.php                       # Configuration admin
├── install.php                          # Script d'installation
├── test-shipping.php                    # Script de test
└── composer.json                        # Configuration Composer
```

## Dépannage

### Le plugin n'apparaît pas en frontend
1. Vérifiez que le plugin est activé dans l'admin
2. Exécutez `php artisan cache:clear`
3. Vérifiez qu'une adresse de livraison est renseignée
4. Vérifiez que le montant du panier atteint le minimum

### Erreur lors du passage au paiement
1. Vérifiez que le plugin n'interfère pas avec d'autres carriers
2. Exécutez le script de test pour diagnostiquer
3. Vérifiez les logs Laravel pour les erreurs

### Le plugin interfère avec d'autres méthodes
1. Le problème est maintenant résolu avec la nouvelle architecture
2. Le plugin utilise maintenant la configuration standard de Bagisto
3. Chaque carrier est indépendant

## Support
Pour toute question ou problème, consultez les logs Laravel ou exécutez le script de test pour diagnostiquer.

## Version
1.0.0 - Compatible avec Bagisto 1.x 