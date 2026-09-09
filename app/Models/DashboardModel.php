<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $table = 'p_item';

    /**
     * Total seluruh produk
     */
    public function totalProduk()
    {
        return $this->db
            ->table('p_item')
            ->countAllResults();
    }

    /**
     * Total customer
     */
    public function totalCustomer()
    {
        return $this->db
            ->table('customer')
            ->countAllResults();
    }

    /**
     * Jumlah produk dengan stok menipis berdasarkan min_stock dinamis
     */
    public function stokMenipis()
    {
        return $this->db
            ->table('p_item')
            ->where('stock >', 0)
            ->where('stock <= COALESCE(min_stock, 5)', null, false)
            ->countAllResults();
    }

    /**
     * Jumlah produk stok habis
     */
    public function stokHabis()
    {
        return $this->db
            ->table('p_item')
            ->where('stock <=', 0)
            ->countAllResults();
    }

    /**
     * Total penjualan hari ini
     */
    public function penjualanHariIni()
    {
        $result = $this->db
            ->table('t_sale')
            ->selectSum('final_price', 'total')
            ->where('date', date('Y-m-d'))
            ->get()
            ->getRow();

        return (int) ($result->total ?? 0);
    }

    /**
     * Jumlah transaksi hari ini
     */
    public function transaksiHariIni()
    {
        return $this->db
            ->table('t_sale')
            ->where('date', date('Y-m-d'))
            ->countAllResults();
    }

    /**
     * Daftar produk stok menipis berdasarkan min_stock dinamis
     */
    public function barangStokMenipis()
    {
        return $this->db
            ->table('p_item')
            ->select('
                p_item.item_id,
                p_item.barcode,
                p_item.name,
                p_item.stock,
                p_item.min_stock,
                p_unit.name AS unit_name
            ')
            ->join(
                'p_unit',
                'p_unit.unit_id = p_item.unit_id',
                'left'
            )
            ->where('p_item.stock >', 0)
            ->where('p_item.stock <= COALESCE(p_item.min_stock, 5)', null, false)
            ->orderBy('p_item.stock', 'ASC')
            ->orderBy('p_item.name', 'ASC')
            ->limit(10)
            ->get()
            ->getResultArray();
    }

    /**
     * Produk stok habis
     */
    public function barangStokHabis()
    {
        return $this->db
            ->table('p_item')
            ->select('
                p_item.item_id,
                p_item.barcode,
                p_item.name,
                p_item.stock,
                p_unit.name AS unit_name
            ')
            ->join(
                'p_unit',
                'p_unit.unit_id = p_item.unit_id',
                'left'
            )
            ->where('p_item.stock <=', 0)
            ->orderBy('p_item.name', 'ASC')
            ->limit(10)
            ->get()
            ->getResultArray();
    }

    /**
     * 10 transaksi terbaru
     */
    public function penjualanTerbaru()
    {
        return $this->db
            ->table('t_sale')
            ->select('
                t_sale.sale_id,
                t_sale.invoice,
                t_sale.final_price,
                t_sale.date,
                t_sale.created,
                customer.name AS customer_name,
                user.name AS user_name
            ')
            ->join(
                'customer',
                'customer.customer_id = t_sale.customer_id',
                'left'
            )
            ->join(
                'user',
                'user.user_id = t_sale.user_id',
                'left'
            )
            ->orderBy('t_sale.sale_id', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();
    }
}