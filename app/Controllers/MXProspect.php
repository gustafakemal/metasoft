<?php

namespace App\Controllers;

class MXProspect extends BaseController
{
    private $db;

    public function __construct()
    {
        $this->db = new \App\Models\MXProspectModel();
    }
    /**
     * Endpoint ini digunakan untuk menampilkan Form / inputan
     *
     * @return string
     */
    public function index()
    {
        $this->breadcrumbs->add('Dashbor', '/');
        $this->breadcrumbs->add('MXProspect', '/');

        /** Untuk menampilkan SelectBox Pemesan di Form */
        $customers = (new \App\Models\CustomerModel())->getCustomers();

        /** Untuk menampilkan SelectBox Jenis produk di Form */

        /** Untuk menampilkan SelectBox Segmen di Form */

        return view('Forms/MXProspect', [
            'page_title' => 'MX Prospect',
            'breadcrumbs' => $this->breadcrumbs->render(),
            'customers' => $customers
        ]);
    }

    /**
     * Endpoint ini digunakan untuk memproses inputan
     *
     * @return void
     */
    public function addProcess()
    {
        /** Semua inputan dari Form di masukkan ke variable ini dalam Array */
        $data_request = $this->request->getPost();

        /** Un-comment perintah ini untuk debug (melihat inputan) sebelum proses lainnya */
        //dd($data_request);

        /** Menambahkan No Prospek yang digenerate system ke array Form */
        $data_request['NoProspek'] = 1234;

        /** Insert form isian ke DB */
        $insert_data = $this->db->insert($data_request);

        if ( $insert_data ) {
            return redirect()->back()
                            ->with('success', 'Data berhasil ditambahkan');
        } else {
            return redirect()->back()
                ->with('error', '<p>' . implode('</p><p>', $this->db->errors()) . '</p>');
        }

    }
}