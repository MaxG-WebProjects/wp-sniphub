<?php
 /**
  * WPSnipHub - Documentation interne
  *
  * Ce fichier ne sert qu’à la documentation du plugin.
  * Il n’est pas chargé par WordPress, mais peut être ouvert pour référence.
  *
  * Structure du plugin :
  * /wp-content/plugins/wp-sniphub/
  * ├── wp-sniphub.php         -> Fichier principal qui initialise le plugin
  * ├── inc/                   -> Contient tous les modules PHP
  * │   ├── setup.php
  * │   ├── security.php
  * │   ├── custom-login.php
  * │   ├── custom-admin.php
  * │   ├── custom-favicon.php
  * │   ├── hooks.php
  * │   ├── scripts.php
  * │   ├── performance.php
  * │   ├── cleanup.php
  * │   ├── custom-post-types.php
  * │   ├── taxonomies.php
  * │   ├── media-setup.php
  * │   ├── image-size.php
  * │   ├── shortcodes.php
  * │   ├── woocommerce.php
  * │   ├── gravity-forms.php
  * │   ├── greenshift.php
  * │   └── helpers.php
  * ├── css/
  * │   ├── custom-login/
  * │   │   └── styles.css
  * │   └── custom-admin-colors/
  * │       └── color-scheme.css
  * └── img/
  * |   ├── icon.svg
  * |   ├── wp-sniphub-logo.svg.svg
  * │   ├── gravatar-icon-290x290px.png
  * |   ├── dashboard-logo.svg
  * │   └── favicons/
  * │       ├── favicon.ico
  * │       ├── favicon.svg
  * │       ├── favicon-96x96.png
  * │       ├── favicon-32x32.png
  * │       ├── favicon-16x16.png
  * │       ├── apple-touch-icon.png
  * │       ├── web-app-manifest-512x512.png
  * │       ├── web-app-manifest-192x192.png
  * │       ├── safari-pinned-tab.svg
  * │       └── site.webmanifest
  * ├── _docs.php             -> Documentation interne (non chargé)
  * └── README.md             -> Documentation interne (non chargé)
  
  * Description générale :
  * WPSnipHub est un plugin modulable qui permet d'ajouter des fonctionnalités
  * personnalisées à WordPress, même en mode Gutenberg Full Site Editing.
  *
  * Tableau récapitulatif des modules
  * - L’ordre d’exécution est contrôlé via la priorité du hook
  *
  * Exemple :
  * add_action( 'theme_loaded', 'ma_fonction', 20 );
  *
  * Plus le nombre est petit, plus la fonction est exécutée tôt.
  * 
  * ┌──────────────────────────┬──────────┬───────────────────────────────────────────┐
  * │ Modules                  │ Priorité │ Rôle                                      │
  * ├──────────────────────────┼──────────┼───────────────────────────────────────────┤
  * │ setup.php                │ 5        │ Initialisation                            │
  * │ security.php             │ 10       │ Améliorations de sécurité                 │
  * │ custom-login.php         │ 45       │ Personnalisation du login                 │
  * │ custom-admin.php         │ 50       │ Personnalisation de l'admin               │
  * │ custom-favicon.php       │ 15       │ Personnalisation du favicon               │
  * │ hooks.php                │ 45       │ Hooks personnalisés (actions/filters)     │
  * │ scripts.php              │ 40       │ Chargement CSS/JS                         │
  * │ performance.php          │ 45       │ Améliorations des performances            │
  * │ cleanup.php              │ 35       │ Nettoyage WordPress                       │
  * │ custom-post-types.php    │ 30       │ Déclaration des Custom Post Types         │
  * │ taxonomies.php           │ 20       │ Déclaration des taxonomies                │
  * │ media-setup.php          │ 45       │ Ajout de types de média (svg, json)       │
  * │ image-size.php           │ 55       │ Ajout de tailles d'images                 │
  * │ shortcodes.php           │ 25       │ Déclaration des code courts               │
  * │ publications.php         │ 25       │ Ajout de fonctions aux articles           │
  * │ woocommerce.php          │ 25       │ Ajout de fonctions à Woocommerce          │
  * │ gravity-forms.php        │ 45       │ Personnalisation de Gravity Forms         │
  * │ greenshift.php           │ 35       │ Personnalisation du plugin Greenshift     │
  * │ helpers.php              │          │                                           │
  * │                          │          │                                           │
  * │                          │          │                                           │  
  * │                          │          │                                           │
  * └──────────────────────────┴──────────┴───────────────────────────────────────────┘
  *
  * Gestion des modules :
  * - Les modules activés sont stockés dans l’option `muh_enabled_modules`.
  * - L’administrateur peut activer/désactiver les modules depuis le menu WPSnipHub.
  *
  * Bonnes pratiques :
  * - Toujours prefixer les fonctions avec `muh_` pour éviter les conflits.
  * - Ne pas exécuter de code directement dans `_docs.php`.
  * - Utiliser `require_once` pour inclure les modules depuis `wp-sniphub.php`.
  *
  * Auteur : Max Gremez
  * Version : 1.0.0
  * Licence : GPLv2 ou supérieure
  */
