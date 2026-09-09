<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ==============================================================================
// PUBLIC ROUTES
// Tidak membutuhkan login
// ==============================================================================

$routes->get('login', 'Auth::login');
$routes->post('login/process', 'Auth::attemptLogin');
$routes->get('logout', 'Auth::logout');


// ==============================================================================
// PROTECTED ROUTES
// Semua route di bawah membutuhkan login
// ==============================================================================

$routes->group('', ['filter' => 'auth'], static function ($routes) {

    // ==========================================================================
    // DASHBOARD
    // Admin & Kasir
    // ==========================================================================

    $routes->get('/', 'Dashboard::index');
    $routes->get('dashboard', 'Dashboard::index');


    // ==========================================================================
    // CUSTOMER
    // Admin & Kasir
    // ==========================================================================

    $routes->group('customer', static function ($routes) {

        $routes->get('', 'Customer::index');

        $routes->get(
            'create',
            'Customer::create'
        );

        $routes->post(
            'store',
            'Customer::store'
        );

        $routes->get(
            'edit/(:num)',
            'Customer::edit/$1'
        );

        $routes->post(
            'update/(:num)',
            'Customer::update/$1'
        );
    });


    // ==========================================================================
    // POINT OF SALES
    // Admin & Kasir
    // ==========================================================================

    $routes->group('pos', static function ($routes) {

        // Halaman utama POS
        $routes->get(
            '',
            'Pos::index'
        );

        // Rute Pencarian Produk AJAX (Diletakkan di dalam grup pos)
        $routes->get('search-products', 'Pos::searchProducts');

        // Cart
        $routes->post(
            'add-cart',
            'Pos::addCart'
        );

        $routes->post(
            'update-cart/(:num)',
            'Pos::updateCart/$1'
        );

        $routes->get(
            'delete-cart/(:num)',
            'Pos::deleteCart/$1'
        );

        $routes->get(
            'clear-cart',
            'Pos::clearCart'
        );

        // Checkout
        $routes->post(
            'checkout',
            'Pos::checkout'
        );

        // Barcode
        $routes->get(
            'barcode',
            'Pos::barcode'
        );

        // AJAX Cart
        $routes->post(
            'add-cart-ajax',
            'Pos::addCartAjax'
        );

        $routes->get(
            'cart-ajax',
            'Pos::cartAjax'
        );

        $routes->post(
            'update-cart-ajax',
            'Pos::updateCartAjax'
        );

        $routes->post(
            'delete-cart-ajax',
            'Pos::deleteCartAjax'
        );

        // Receipt
        $routes->get(
            'receipt/(:num)',
            'Pos::receipt/$1'
        );

        // Riwayat transaksi
        $routes->get(
            'history',
            'Pos::history'
        );

        $routes->get(
            'history-ajax',
            'Pos::historyAjax'
        );

        // Detail Transaksi AJAX (Modal)
        $routes->get(
            'sale-detail-ajax/(:num)',
            'Pos::saleDetailAjax/$1'
        );

       // Export PDF Riwayat Penjualan
        $routes->get(
            'export-pdf',
            'Pos::exportPdf'
        );

        
    });


    // ==========================================================================
    // ADMIN ONLY
    // Semua route setelah bagian ini hanya dapat diakses Admin
    // ==========================================================================


    // ==========================================================================
    // CATEGORY MANAGEMENT
    // ==========================================================================

    $routes->group(
        'category',
        ['filter' => 'admin'],
        static function ($routes) {

            $routes->get(
                '',
                'Category::index'
            );

            $routes->get(
                'create',
                'Category::create'
            );

            $routes->post(
                'store',
                'Category::store'
            );

            $routes->get(
                'edit/(:num)',
                'Category::edit/$1'
            );

            $routes->post(
                'update/(:num)',
                'Category::update/$1'
            );

            $routes->get(
                'delete/(:num)',
                'Category::delete/$1'
            );
        }
    );


    // ==========================================================================
    // UNIT MANAGEMENT
    // ==========================================================================

    $routes->group(
        'unit',
        ['filter' => 'admin'],
        static function ($routes) {

            $routes->get(
                '',
                'Unit::index'
            );

            $routes->get(
                'create',
                'Unit::create'
            );

            $routes->post(
                'store',
                'Unit::store'
            );

            $routes->get(
                'edit/(:num)',
                'Unit::edit/$1'
            );

            $routes->post(
                'update/(:num)',
                'Unit::update/$1'
            );

            $routes->get(
                'delete/(:num)',
                'Unit::delete/$1'
            );
        }
    );


    // ==========================================================================
    // ITEM / PRODUK MANAGEMENT
    // ==========================================================================

    $routes->group(
        'item',
        ['filter' => 'admin'],
        static function ($routes) {

            $routes->get(
                '',
                'Item::index'
            );

            $routes->get(
                'create',
                'Item::create'
            );

            $routes->post(
                'store',
                'Item::store'
            );

            $routes->get(
                'edit/(:num)',
                'Item::edit/$1'
            );

            $routes->post(
                'update/(:num)',
                'Item::update/$1'
            );

            $routes->get(
                'delete/(:num)',
                'Item::delete/$1'
            );
        }
    );


    // ==========================================================================
    // SUPPLIER MANAGEMENT
    // ==========================================================================

    $routes->group(
        'supplier',
        ['filter' => 'admin'],
        static function ($routes) {

            $routes->get(
                '',
                'Supplier::index'
            );

            $routes->get(
                'create',
                'Supplier::create'
            );

            $routes->post(
                'store',
                'Supplier::store'
            );

            $routes->get(
                'edit/(:num)',
                'Supplier::edit/$1'
            );

            $routes->post(
                'update/(:num)',
                'Supplier::update/$1'
            );

            $routes->get(
                'delete/(:num)',
                'Supplier::delete/$1'
            );
        }
    );


    // ==========================================================================
    // STOCK / GUDANG
    // Admin Only
    // ==========================================================================

    $routes->group(
        'stock',
        ['filter' => 'admin'],
        static function ($routes) {

            $routes->get(
                '',
                'Stock::index'
            );

            $routes->get(
                'masuk',
                'Stock::masuk'
            );

            $routes->post(
                'store-masuk',
                'Stock::storeMasuk'
            );

            $routes->get(
                'keluar',
                'Stock::keluar'
            );

            $routes->post(
                'store-keluar',
                'Stock::storeKeluar'
            );
        }
    );


    // ==========================================================================
    // USER MANAGEMENT/SETTINGS
    // Admin Only
    // ==========================================================================

    $routes->group(
        'user',
        ['filter' => 'admin'],
        static function ($routes) {

            $routes->get(
                '',
                'User::index'
            );

            $routes->get(
                'create',
                'User::create'
            );

            $routes->post(
                'store',
                'User::store'
            );

            $routes->get(
                'edit/(:num)',
                'User::edit/$1'
            );

            $routes->post(
                'update/(:num)',
                'User::update/$1'
            );

            $routes->post(
                'delete/(:num)',
                'User::delete/$1'
            );
        }
    );

    $routes->get('settings', 'Settings::index');
    $routes->post('settings/update', 'Settings::update');

});