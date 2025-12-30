<img src="https://github.com/MaxG-WebProjects/wp-sniphub/blob/main/img/wp-sniphub-logo.svg" alt="Logo GreenLight Addon" width="200"/>

# WP-SnipHub
Central hub for snippets and utility functions for WordPress sites.

# Documentation

## Description

**WPSnipHub : gestion des modules MU** est un plugin proposant :

- Personnalisation du tableau de bord WordPress (logo, couleurs, footer, avatars).  
- Personnalisation de la page de connexion.  
- Gestion des scripts et styles front-end et back-end.  
- Déclaration de types de contenus et taxonomies personnalisés.  
- Déclaration de shortcodes réutilisables.  
- Sécurisation et nettoyage du site WordPress.  
- Fonctions helpers réutilisables dans les modules.  

Chaque fonctionnalité est incluse sous forme de **module**, activable ou désactivable via la page d’administration.

---

## Objectif

L’objectif est d’assurer :
- Une meilleure lisibilité du code
- Une maintenance facilitée
- Une activation/désactivation simple des modules
- Une conformité avec les bonnes pratiques WordPress

---

## Installation

1. Placer le dossier `wp-sniphub` dans le répertoire :  wp-content/plugins/
2. Activer le plugin depuis l’admin WordPress.  
3. Accéder à **WPSnipHub : gestion des modules MU** pour activer/désactiver les modules souhaités.

---

## Structure du plugin

```
wp-sniphub/
│
├── wp-sniphub.php
│
├── inc/
│   ├── setup.php
│   ├── security.php
│   ├── custom-login.php
│   ├── custom-admin.php
│   ├── custom-favicon.php
│   ├── hooks.php
│   ├── scripts.php
│   ├── performance.php
│   ├── cleanup.php
│   ├── custom-post-types.php
│   ├── taxonomies.php
│   ├── media-setup.php
│   ├── image-size.php
│   ├── shortcodes.php
│   ├── publications.php
│   ├── woocommerce.php
│   ├── gravity-forms.php
│   ├── greenshift.php
│   └── helpers.php
│   
├── css/
│   ├── admin/
│   │   └── wpsh-admin.css
│   │   
│   ├── custom-login/
│   │   └── styles.css
│   │   
│   └── custom-admin-colors/
│       └── color-scheme.css
│   
├── img/
│   ├── icon.svg
│   ├── gravatar-icon-290x290px.png
│   └── favicons/
│       ├── favicon.ico
│       ├── favicon.svg
│       ├── favicon-16x16.png
│       ├── favicon-32x32.png
│       ├── favicon-96x96.png
│       ├── apple-touch-icon.png
│       ├── web-app-manifest-192x192.png
│       ├── web-app-manifest-512x512.png
│       ├── safari-pinned-tab.svg
│       └── site.webmanifest
│   
├── _docs.php # Documentation interne (non chargé)
└── README.md # Documentation interne (non chargé)
```



 
---

## Ordre d’exécution (priorités)
```
┌──────────────────────────┬──────────┬───────────────────────────────────────────┐
│ Modules                  │ Priorité │ Rôle                                      │
├──────────────────────────┼──────────┼───────────────────────────────────────────┤
│ setup.php                │ 5        │ Initialisation                            │
│ security.php             │ 10       │ Améliorations de sécurité                 │
│ custom-login.php         │ 45       │ Personnalisation du login                 │
│ custom-admin.php         │ 50       │ Personnalisation de l'admin               │
│ custom-favicon.php       │ 15       │ Personnalisation du favicon               │
│ hooks.php                │ 45       │ Hooks personnalisés (actions/filters)     │
│ scripts.php              │ 40       │ Chargement CSS/JS                         │
│ performance.php          │ 45       │ Améliorations des performances            │
│ cleanup.php              │ 35       │ Nettoyage WordPress                       │
│ custom-post-types.php    │ 30       │ Déclaration des Custom Post Types         │
│ taxonomies.php           │ 20       │ Déclaration des taxonomies                │
│ media-setup.php          │ 45       │ Ajout de types de média (svg, json)       │
│ image-size.php           │ 55       │ Ajout de tailles d'images                 │
│ shortcodes.php           │ 25       │ Déclaration des code courts               │
│ publications.php         │ 25       │ Ajout de fonctions aux articles           │
│ woocommerce.php          │ 25       │ Ajout de fonctions à Woocommerce          │
│ gravity-forms.php        │ 45       │ Personnalisation de Gravity Forms         │
│ greenshift.php           │ 35       │ Personnalisation du plugin Greenshift     │
│ helpers.php              │ 20       │ Divers                                    │
│                          │          │                                           │
│                          │          │                                           │  
│                          │          │                                           │
└──────────────────────────┴──────────┴───────────────────────────────────────────┘
```

## Sécurité appliquée

- Blocage de l’accès direct à tous les fichiers (if ( ! defined( 'ABSPATH' ) ) exit;)
- Suppression des emojis et balises inutiles (cleanup.php)
- Désactivation de l’éditeur de fichiers dans l’admin (security.php)
- Masquage de la version WordPress

---

## Bonnes pratiques

- Documenter chaque module dans inc/_docs.php
- Toujours utiliser le hook theme_loaded pour centraliser le chargement
- Gérer l’ordre avec des priorités cohérentes (5 → 100)
- Activer/désactiver les modules via $theme_modules plutôt que supprimer du code

---
