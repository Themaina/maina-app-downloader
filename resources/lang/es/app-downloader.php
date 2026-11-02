<?php

return [
    'name' => 'Smart App Downloader',

    'settings' => [
        'title' => 'Descarga de la app',
        'description' => 'Un único enlace /download inteligente que envía a cada visitante a la tienda o instalador correcto.',
    ],

    'sections' => [
        'options' => 'Opciones',
        'links_mobile' => 'Enlaces móviles',
        'links_desktop' => 'Enlaces de escritorio',
        'files' => 'Subir instaladores (se usan en lugar del enlace)',
        'branding' => 'Página de selección',
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

    'link_label' => 'Enlace de :platform',

    'info' => [
        'your_link' => 'Tu enlace de descarga. Compártelo donde quieras.',
        'copy' => 'Copiar',
        'copied' => 'Copiado',
        'open' => 'Abrir',
        'test_as' => 'Probar como:',
        'no_links' => 'Añade un enlace abajo para empezar a probar.',
        'preview_design' => 'Vista previa del diseño:',
        'qr_download' => 'Descargar QR',
        'stats_title' => 'visitas en los últimos 30 días',
        'stats_empty' => 'Aún no hay visitas.',
        'stats_chooser' => 'Página de selección',
    ],

    'enabled' => 'Redirigir visitantes automáticamente',
    'track' => 'Contar visitas',

    'designs' => [
        'minimal' => 'Minimalista',
        'hero' => 'Destacado',
        'split' => 'Dividido',
        'tiles' => 'Tarjetas',
    ],
    'design' => 'Diseño de la página',
    'accent_color' => 'Color de acento',

    'app_name' => 'Nombre de la app',
    'tagline' => 'Descripción breve',
    'icon' => 'Icono de la app',
    'deep_link' => 'Enlace "Abrir en la app"',

    'upload' => [
        'none' => 'Sin archivo. Acepta :types',
        'choose' => 'Subir',
        'replace' => 'Reemplazar',
        'remove' => 'Quitar',
        'confirm_remove' => '¿Quitar este archivo?',
        'bad_type' => 'Para esta plataforma solo se permiten archivos :types.',
        'out_of_order' => 'La subida se interrumpió. Inténtalo de nuevo.',
        'failed' => 'La subida falló. Inténtalo de nuevo.',
        'too_big' => 'El archivo supera los 2 GB.',
    ],

    'page_title' => 'Descarga la app',
    'get_app' => 'Descarga :name',
    'page_description' => 'Elige tu plataforma para descargar la app.',
    'no_links_configured' => 'Los enlaces de descarga aún no están disponibles. Vuelve pronto.',
    'other_platforms' => 'Otras plataformas',
    'download_for' => 'Descargar para :platform',
    'download' => 'Descargar',
    'for_you' => 'Para tu dispositivo',
    'open_app' => '¿Ya la instalaste? Abre la app',

    'invalid_deep_link' => 'Introduce un enlace de app válido como myapp://open o una URL https.',
];
