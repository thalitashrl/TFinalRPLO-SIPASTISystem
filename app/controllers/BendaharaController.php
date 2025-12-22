<?php
class BendaharaController extends Controller {
    
    public function index() {
        $data['judul'] = 'Dashboard Bendahara';

        // Panggil Model
        $transaksiModel = $this->model('TransaksiModel');

        // Ambil data Saldo Kas lewat Model (Bukan query langsung di sini)
        $data['stats']['kas'] = $transaksiModel->getSaldoKas();

        // Tampilkan View
        $this->view('bendahara/dashboard', $data);
    }
}