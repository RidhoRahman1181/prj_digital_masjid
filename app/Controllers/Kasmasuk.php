<?php

namespace App\Controllers;

use App\Models\Modelkasmasuk;


class Kasmasuk extends BaseController
{
    public function index()
    {
        if (session()->get('masuk') == true) {
            if (session()->get('level') == 1) {
                $model = new Modelkasmasuk();
                $data['kasmasuk'] = $model->getkasmasuk()->getResultArray();
                $data['data_donatur'] = $model->getDonatur()->getResult();
                echo view('kas/view_kasmasuk', $data);
            } else {
                echo "<script>alert('Anda Tidak Berhak Mengakses Kas Masuk'); window.location.href='/login';</script>";
            }
        } else {
            echo "<script>alert('Anda Belum Login, Silahkan Login Terlebih Dahulu'); window.location.href='/login';</script>";
        }
    }
    public function save()
    {
        $model = new Modelkasmasuk();
        $data = array(

            'tanggal' => $this->request->getPost('tanggal'),
            //'nama' => $this->request->getPost('nama'),
            'ket' => $this->request->getPost('ket'),
            'kas_masuk' => $this->request->getPost('kas_masuk'),
            'kas_keluar' => 0,
            'jenis_kas' => $this->request->getPost('jenis_kas'),
            'status' => "masuk",
            'iddonaturmasjid' => $this->request->getPost('iddonatur'),
            'idkegiatan' => $this->request->getPost('id_agenda'),
        );



        $model->insertData($data);
        return redirect()->to('/Kasmasuk');
    }
    public function delete()
    {
        $model = new Modelkasmasuk();
        $id = $this->request->getPost('id');
        $model->deletekasmasuk($id);
        return redirect()->to('/Kasmasuk/index');
    }

    public function update()
    { {
            $model = new Modelkasmasuk();
            $id = $this->request->getPost('tanggal');
            $data = array(
                'tanggal' => $this->request->getPost('tanggal'),
                // 'nama' => $this->request->getPost('nama'),
                'ket' => $this->request->getPost('ket'),
                'kas_masuk' => $this->request->getPost('kas_masuk'),
                'jenis_kas' => $this->request->getPost('jenis_kas'),
                'status' => "masuk",
                'iddonaturmasjid' => $this->request->getPost('iddonatur'),
            );
            $model->updatekasmasuk($data, $id);
            return redirect()->to('/Kasmasuk/index');
        }
    }

    public function laporankasmasuk()
    {
        $model = new ModelKasMasuk();
        $data['data'] = $model->laporankasmasuk()->getResultArray();
        echo view('kas/cetak_laporan_masuk', $data);
    }

    public function laporanperperiode()
    {
        echo view('kas/vlaporankasmasuk');
    }
    public function cetaklaporanperperiode()
    {
        $model = new ModelKasMasuk();

        $tgla = $this->request->getPost('tanggal_awal');
        $tglb = $this->request->getPost('tanggal_akhir');
        $query = $model->getLaporanperperiode($tgla, $tglb)->getResultArray();
        $data = [
            'tgla' => $tgla,
            'tglb' => $tglb,
            'data' => $query
        ];
        echo view('kas/vcetaklaporanperperiode', $data);
    }

    public function laporanperperiodeperjenis()
    {
        echo view('kas/vlaporanperjeniskas');
    }

    public function cetaklaporanperperiodeperjeniskas()
    {
        $model = new ModelKasMasuk();
        $tgla = $this->request->getPost('tanggal_awal');
        $tglb = $this->request->getPost('tanggal_akhir');
        $jenis = $this->request->getPost('jeniskas');
        $query = $model->getLaporanperperiodeperjeniskas($tgla, $tglb, $jenis)->getResultArray();
        $data = [
            'tgla' => $tgla,
            'tglb' => $tglb,
            'jenis' => $jenis,
            'data' => $query,
        ];
        echo view('kas/v_cetaklaporanperperiodeperjeniskas', $data);
    }
}
