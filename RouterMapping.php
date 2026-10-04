<?php

/**
 * Tambahkan mapping ini ke Router.php di method run()
 * Ganti bagian $controllerClass = ucfirst... dengan kode di bawah ini
 */

// MAPPING CONTROLLER
// URL: /admin/xxx     → AdminController
// URL: /pimpinan/xxx  → PimpinanController
// URL: /penjualan/xxx → PenjualanController
// URL: /home/xxx      → HomeController
// URL: /auth/xxx      → AuthController
// URL: /penyewaan/xxx → PenyewaanController
// URL: /pembayaran/xx → PembayaranController
// URL: /pengembalian  → PengembalianController
// URL: /pelanggan/xx  → PelangganController

$controllerMap = [
    'admin'        => 'AdminController',
    'pimpinan'     => 'PimpinanController',
    'penjualan'    => 'PenjualanController',
    'home'         => 'HomeController',
    'auth'         => 'AuthController',
    'penyewaan'    => 'PenyewaanController',
    'pembayaran'   => 'PembayaranController',
    'pengembalian' => 'PengembalianController',
    'pelanggan'    => 'PelangganController',
    'surat'        => 'SuratController',
];

$controllerClass = $controllerMap[$controllerName] ?? ucfirst(strtolower($controllerName)) . 'Controller';