<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SettingModel;

class Settings extends BaseController
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    /**
     * Menampilkan halaman form edit pengaturan toko
     */
    public function index()
    {
        $data = [
            'title'   => 'Pengaturan Toko & Struk',
            'setting' => $this->settingModel->getSetting()
        ];

        // Sesuaikan dengan path view form Anda (misal: admin/settings/index)
        return view('settings/index', $data);
    }

    /**
     * Memproses data yang dikirim dari form CRUD
     */
    public function update()
    {
        $postData = [
            'store_name'     => $this->request->getPost('store_name'),
            'store_address'  => $this->request->getPost('store_address'),
            'store_phone'    => $this->request->getPost('store_phone'),
            'receipt_footer' => $this->request->getPost('receipt_footer'),
        ];

        $this->settingModel->saveSetting($postData);

        return redirect()->to('/settings')->with('success', 'Pengaturan toko berhasil diperbarui!');
    }
}