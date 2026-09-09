<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface
{
    public function before(
        RequestInterface $request,
        $arguments = null
    ) {
        if (!session()->get('logged_in')) {
            return redirect()
                ->to(base_url('login'))
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        if ((string) session()->get('level') !== '1') {
            return redirect()
                ->to(base_url('dashboard'))
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }
    }

    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ) {
        // Tidak ada proses setelah request.
    }
}