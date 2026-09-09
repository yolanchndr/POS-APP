<?php

namespace App\Controllers;

use App\Models\DashboardModel;

class Dashboard extends BaseController
{
    protected $dashboardModel;

    public function __construct()
    {
        $this->dashboardModel = new DashboardModel();
    }

    public function index()
    {
        $batasStok = 5;

        $data = [
            'title' => 'Dashboard',

            // Statistik
            'totalProduk' => $this->dashboardModel->totalProduk(),

            'totalCustomer' => $this->dashboardModel->totalCustomer(),

            'stokMenipis' => $this->dashboardModel
                ->stokMenipis($batasStok),

            'stokHabis' => $this->dashboardModel
                ->stokHabis(),

            'penjualanHariIni' => $this->dashboardModel
                ->penjualanHariIni(),

            'transaksiHariIni' => $this->dashboardModel
                ->transaksiHariIni(),

            // Detail stok
            'barangStokMenipis' => $this->dashboardModel
                ->barangStokMenipis($batasStok),

            'barangStokHabis' => $this->dashboardModel
                ->barangStokHabis(),

            // Transaksi
            'penjualanTerbaru' => $this->dashboardModel
                ->penjualanTerbaru(),
        ];

        return view('dashboard/index', $data);
    }
}