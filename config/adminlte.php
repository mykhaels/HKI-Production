<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#61-title
    |
    */

    'title' => 'Admin',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#62-favicon
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#63-logo
    |
    */

    'logo' => 'PT Bernadi Utama',
    'logo_img' => '/vendor/adminlte/dist/img/Logo2.jpg',
    'logo_img_class' => 'brand-image',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'LOGO Bernadi',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#64-user-menu
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-dark',
    'usermenu_image' => true,
    'usermenu_desc' => true,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#65-layout
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#661-authentication-views-classes
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#662-admin-panel-classes
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-light-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-dark navbar-lightblue',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#67-sidebar
    |
    */

    'sidebar_mini' => true,
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => true,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#68-control-sidebar-right-sidebar
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#69-urls
    |
    */

    'use_route_url' => false,

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'login_url' => 'login',

    'register_url' => 'register',

    'password_reset_url' => 'password/reset',

    'password_email_url' => 'password/email',

    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#610-laravel-mix
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#611-menu
    |
    */

    'menu' => [
        ['header' => 'MASTER'
        ],
        [
            'text' => 'Master Kategori Produk ',
            'url'  => 'product-category',
            'icon' => 'fas fa-bezier-curve',
        ],
        // [
        //     'text' => 'Master Supplier ',
        //     'url'  => 'supplier',
        //     'icon' => 'fas fa-bezier-curve',
        // ],
        [
            'text' => 'Master Produk',
            'url'  => 'product',
            'icon' => 'fab fa-product-hunt',
        ],
        [
            'text' => 'Master Pelanggan',
            'url'  => 'customer',
            'icon' => 'fab fa-product-hunt',
        ],
        [
            'text' => 'Master Akun',
            'url'  => 'account',
            'icon' => 'fab fa-product-hunt',
        ],
        // ['header' => 'PEMBELIAN'],
        // [
        //     'text' => 'Pesanan Pembelian',
        //     'url'  => 'purchase-order',
        //     'icon' => 'fas fa-bezier-curve',
        // ],
        // [
        //     'text' => 'Uang Muka Pembelian',
        //     'url'  => 'initial-payment',
        //     'icon' => 'fas fa-bezier-curve',
        // ],
        // [
        //     'text' => 'Penerimaan Pembelian',
        //     'url'  => 'good-receipt',
        //     'icon' => 'fab fa-product-hunt',
        // ],
        // [
        //     'text' => 'Retur Pembelian',
        //     'url'  => 'retur',
        //     'icon' => 'fab fa-product-hunt',
        // ],
        // [
        //     'text' => 'Faktur Pembelian',
        //     'url'  => 'invoice',
        //     'icon' => 'fab fa-product-hunt',
        // ],
        // [
        //     'text' => 'Pelunasan Pembelian',
        //     'url'  => 'settlement',
        //     'icon' => 'fab fa-product-hunt',
        // ],
        // [
        //     'text' => 'Penghapusan Pembelian',
        //     'url'  => 'writeoff',
        //     'icon' => 'fab fa-product-hunt',
        // ],
        ['header' => 'PENJUALAN'],
        [
            'text' => 'Pesanan Penjualan',
            'url'  => 'sales-order',
            'icon' => 'fas fa-bezier-curve',
        ],
        // [
        //     'text' => 'Uang Muka Penjualan',
        //     'url'  => 'initial-payment-sales',
        //     'icon' => 'fas fa-bezier-curve',
        // ],
        [
            'text' => 'Surat Jalan',
            'url'  => 'sales-delivery-note',
            'icon' => 'fab fa-product-hunt',
        ],
        [
            'text' => 'Retur Penjualan',
            'url'  => 'retur-sales',
            'icon' => 'fab fa-product-hunt',
        ],
        [
            'text' => 'Faktur Penjualan',
            'url'  => 'sales-invoice',
            'icon' => 'fab fa-product-hunt',
        ],
        [
            'text' => 'Pelunasan Penjualan',
            'url'  => 'sales-settlement',
            'icon' => 'fab fa-product-hunt',
        ],
        [
            'text' => 'Penghapusan Penjualan',
            'url'  => 'sales-writeoff',
            'icon' => 'fab fa-product-hunt',
        ],
        [
            'text' => 'Laporan Penjualan',
            'url'  => 'report/sales-report',
            'icon' => 'fab fa-product-hunt',
        ],
        [
            'text' => 'Laporan Pembayaran',
            'url'  => 'report/payment-report',
            'icon' => 'fab fa-product-hunt',
        ],
        ['header' => 'JURNAL'],
        [
            'text' => 'Jurnal ',
            'url'  => 'journal',
            'icon' => 'fas fa-warehouse',
        ],

        ['header' => 'PERSEDIAAN'],
        [
            'text' => 'Pengeluaran Produksi ',
            'url'  => 'delivery-note',
            'icon' => 'fas fa-warehouse',
        ],
        [
            'text' => 'Permintaan Kirim Barang ',
            'url'  => 'transfer-request',
            'icon' => 'fas fa-warehouse',
        ],
        [
            'text' => 'Penerimaan Transfer ',
            'url'  => 'transfer-in',
            'icon' => 'fas fa-warehouse',
        ],
        // ['header' => 'PRODUKSI'],
        // [
        //     'text' => 'Perintah Produksi ',
        //     'url'  => 'production-order',
        //     'icon' => 'fab fa-first-order',
        // ],
        // [
        //     'text' => 'Permintaan Produksi',
        //     'url'  => 'delivery-request',
        //     'icon' => 'fas fa-code-branch',
        // ],
        // [
        //     'text' => 'Hasil Produksi',
        //     'url'  => 'production-result',
        //     'icon' => 'fas fa-cubes',
        // ],




    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#612-menu-filters
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#613-plugins
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],
];
