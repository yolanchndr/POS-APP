<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Pastikan hanya Admin
     */
    private function requireAdmin()
    {
        if (!is_logged_in()) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        if (!is_admin()) {
            return redirect()->to(base_url('dashboard'))->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return null;
    }

    /**
     * Daftar user
     */
    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $keyword = trim($this->request->getGet('q') ?? '');
        $builder = $this->userModel;

        if ($keyword !== '') {
            $builder->groupStart()
                ->like('username', $keyword)
                ->orLike('name', $keyword)
                ->groupEnd();
        }

        $users = $builder->orderBy('user_id', 'DESC')->paginate(15);

        return view('user/index', [
            'users'   => $users,
            'pager'   => $this->userModel->pager,
            'keyword' => $keyword,
        ]);
    }

    /**
     * Form tambah
     */
    public function create()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return view('user/create');
    }

    /**
     * Simpan user
     */
    public function store()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $rules = [
            'username' => 'required|min_length[3]|max_length[40]',
            'name'     => 'required|max_length[100]',
            'password' => 'required|min_length[6]',
            'level'    => 'required|in_list[1,2]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = trim($this->request->getPost('username'));
        $exists   = $this->userModel->where('username', $username)->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Username sudah digunakan.');
        }

        $this->userModel->insert([
            'username' => $username,
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'name'     => trim($this->request->getPost('name')),
            'address'  => trim($this->request->getPost('address') ?? ''),
            'level'    => $this->request->getPost('level'),
        ]);

        return redirect()->to(base_url('user'))->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to(base_url('user'))->with('error', 'User tidak ditemukan.');
        }

        return view('user/edit', [
            'user' => $user
        ]);
    }

    /**
     * Update user
     */
    public function update($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to(base_url('user'))->with('error', 'User tidak ditemukan.');
        }

        $rules = [
            'username' => 'required|min_length[3]|max_length[40]',
            'name'     => 'required|max_length[100]',
            'level'    => 'required|in_list[1,2]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = trim($this->request->getPost('username'));
        $exists   = $this->userModel->where('username', $username)->where('user_id !=', $id)->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Username sudah digunakan.');
        }

        $data = [
            'username' => $username,
            'name'     => trim($this->request->getPost('name')),
            'address'  => trim($this->request->getPost('address') ?? ''),
            'level'    => $this->request->getPost('level'),
        ];

        $password = $this->request->getPost('password');

        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);

        // Jika user mengedit dirinya sendiri, update session level/name.
        if ((int) session()->get('user_id') === (int) $id) {
            session()->set([
                'name'  => $data['name'],
                'level' => $data['level'],
            ]);
        }

        return redirect()->to(base_url('user'))->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Hapus user
     */
    public function delete($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        // Jangan izinkan admin menghapus akun yang sedang digunakan.
        if ((int) session()->get('user_id') === (int) $id) {
            return redirect()->to(base_url('user'))->with('error', 'Akun yang sedang digunakan tidak dapat dihapus.');
        }

        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to(base_url('user'))->with('error', 'User tidak ditemukan.');
        }

        $this->userModel->delete($id);

        return redirect()->to(base_url('user'))->with('success', 'User berhasil dihapus.');
    }
}