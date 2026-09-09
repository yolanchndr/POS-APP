<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table            = 'store_settings';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'store_name', 
        'store_address', 
        'store_phone', 
        'receipt_footer'
    ];

    /**
     * Mengambil data pengaturan toko (karena hanya ada 1 baris, kita ambil ID = 1)
     */
    public function getSetting()
    {
        // Mencari data dengan ID 1, atau mengambil baris pertama jika tabel kosong
        $setting = $this->find(1);
        
        if (!$setting) {
            // Data default jika tabel masih kosong
            return [
                'store_name'     => 'Lorem Ipsum Store',
                'store_address'  => 'Lorem ipsum dolor sit amet,<br>Consectetur adipiscing elit',
                'store_phone'    => '081234567890 / 082345678901',
                'receipt_footer' => "Lorem ipsum dolor sit amet.\nLorem ipsum dolor sit amet.\nLorem ipsum dolor sit amet."
            ];
        }
        return $setting;
    }

    /**
     * Menyimpan/Memperbarui pengaturan toko
     */
    public function saveSetting($data)
    {
        // Cek apakah data dengan ID 1 sudah ada
        $exists = $this->find(1);

        if ($exists) {
            // Update data jika sudah ada
            return $this->update(1, $data);
        } else {
            // Insert data baru dengan ID diset ke 1 jika belum ada
            $data['id'] = 1;
            return $this->insert($data);
        }
    }
}