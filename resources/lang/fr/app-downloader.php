<?php

return [
    'name' => 'Smart App Downloader',

    'settings' => [
        'title' => 'Téléchargement de l\'app',
        'description' => 'Un seul lien /download intelligent qui envoie chaque visiteur vers la bonne boutique ou le bon installateur.',
    ],

    'sections' => [
        'options' => 'Options',
        'links_mobile' => 'Liens mobiles',
        'links_desktop' => 'Liens ordinateur',
        'files' => 'Téléverser les installateurs (utilisés à la place du lien)',
        'branding' => 'Page de choix',
    ],

    'platforms' => [
        'ios' => 'iOS',
        'android' => 'Android',
        'huawei' => 'Huawei AppGallery',
        'amazon' => 'Amazon Appstore',
        'windows' => 'Windows',
        'microsoft' => 'Microsoft Store',
        'macos' => 'macOS',
        'linux' => 'Linux',
    ],

    'link_label' => 'Lien :platform',

    'info' => [
        'your_link' => 'Votre lien de téléchargement. Partagez-le partout.',
        'copy' => 'Copier',
        'copied' => 'Copié',
        'open' => 'Ouvrir',
        'test_as' => 'Tester en tant que :',
        'no_links' => 'Ajoutez un lien ci-dessous pour commencer les tests.',
        'preview_design' => 'Aperçu du design :',
        'qr_download' => 'Télécharger le QR',
        'stats_title' => 'visites ces 30 derniers jours',
        'stats_empty' => 'Aucune visite pour le moment.',
        'stats_chooser' => 'Page de choix',
    ],

    'enabled' => 'Rediriger automatiquement les visiteurs',
    'track' => 'Compter les visites',

    'designs' => [
        'minimal' => 'Minimal',
        'hero' => 'Bannière',
        'split' => 'Deux colonnes',
        'tiles' => 'Cartes',
    ],
    'design' => 'Design de la page',
    'accent_color' => 'Couleur d\'accent',

    'app_name' => 'Nom de l\'app',
    'tagline' => 'Slogan',
    'icon' => 'Icône de l\'app',
    'deep_link' => 'Lien « Ouvrir dans l\'app »',

    'upload' => [
        'none' => 'Aucun fichier. Accepte :types',
        'choose' => 'Téléverser',
        'replace' => 'Remplacer',
        'remove' => 'Supprimer',
        'confirm_remove' => 'Supprimer ce fichier ?',
        'bad_type' => 'Seuls les fichiers :types sont autorisés pour cette plateforme.',
        'out_of_order' => 'Le téléversement a été interrompu. Veuillez réessayer.',
        'failed' => 'Le téléversement a échoué. Veuillez réessayer.',
        'too_big' => 'Le fichier dépasse 2 Go.',
    ],

    'page_title' => 'Obtenez l\'app',
    'get_app' => 'Obtenez :name',
    'page_description' => 'Choisissez votre plateforme pour télécharger l\'app.',
    'no_links_configured' => 'Les liens de téléchargement ne sont pas encore disponibles. Revenez bientôt.',
    'other_platforms' => 'Autres plateformes',
    'download_for' => 'Télécharger pour :platform',
    'download' => 'Télécharger',
    'for_you' => 'Pour votre appareil',
    'open_app' => 'Déjà installée ? Ouvrir l\'app',

    'invalid_deep_link' => 'Saisissez un lien d\'app valide, comme myapp://open, ou une URL https.',
];
