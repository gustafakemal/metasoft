<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class MXProspectModel extends Model
{
    protected $table = 'MX_Prospek';
    protected $useTimestamps = true;
    protected $createdField = 'Created';
    protected $updatedField = 'Updated';
    protected $allowedFields = ['NoProspek', 'Alt', 'Tanggal', 'NamaProduk', 'Pemesan', 'Segmen', 'Konten', 'JenisProduk', 'Tebal', 'Panjang', 'Lebar', 'Pitch', 'Material1', 'TebalMat1', 'Material2', 'TebalMat2', 'Material3', 'TebalMat3', 'Material4', 'TebalMat4', 'Warna', 'Eyemark', 'RollDirection', 'Catatan', 'MaxJoin', 'WarnaTape', 'BagMaking', 'Bottom', 'OpenForFilling', 'Roll_Pcs', 'Finishing', 'Toleransi', 'Parsial', 'Keterangan', 'Area', 'Jalur', 'Kapasitas', 'Created', 'CreatedBy', 'Updated', 'UpdatedBy', 'Status', 'JenisTinta', 'JenisAdhesive', 'JenisPieces', 'Sales', 'Estimator', 'EstimasiUpdated', 'EstimasiUpdatedBy', 'EstimasiChecked', 'EstimasiCheckedBy', 'MeterRoll', 'Gusset', 'CentreSeal', 'Prioritas', 'JumlahUp', 'LebarFilm', 'UkuranBottom', 'Lampiran1', 'FileLampiran1'];

    protected $validationRules = [];
    //     'NamaProduk' => 'required',
    //     'Pemesan' => 'required',
    //     'Segmen' => 'required',
    //     'Konten' => 'required',
    //     'JenisProduk' => 'required',
    //     'Jalur' => 'required',
    //     'Area' => 'required',
    //     'Roll_Pcs' => 'required',
    //     // 'Lampiran1' => 'required',
    //     //'Tebal' => 'required|greater_than[0]',
    //     //'Panjang' => 'required|greater_than[0]',
    //     //'Lebar' => 'required|greater_than[0]',
    //     //'Pitch' => 'required|greater_than[0]',
    //     //'Material1' => 'required',
    //     //'TebalMat1' => 'required|greater_than[0]',
    //     //'Kapasitas' => 'required|greater_than[0]',
    // ];

    // protected $validationMessages = [
    //     'NamaProduk' => [
    //         'required' => 'Field Nama Produk harus diisi.',
    //     ],
    //     'Pemesan' => [
    //         'required' => 'Field Pemesan harus diisi.',
    //     ],
    //     'Segmen' => [
    //         'required' => 'Field Segmen harus diisi.',
    //     ],
    //     'Konten' => [
    //         'required' => 'Field Konten harus diisi.',
    //     ],
    //     'JenisProduk' => [
    //         'required' => 'Field Jenis Produk harus diisi.',
    //     ],
    //     'Jalur' => [
    //         'required' => 'Field Jalur Pengiriman harus diisi.',
    //     ],
    //     'Area' => [
    //         'required' => 'Field Area harus diisi.',
    //     ],
    //     'Roll_Pcs' => [
    //         'required' => 'Field Satuan Roll/Pcs harus diisi.',
    //     // ],
    //     // 'Lampiran1' => [
    //     //     'required' => 'Field Lampiran harus diisi.',
    //     // ],
    //     // 'Kapasitas' => [
    //     //     'required' => 'Field Kapasitas harus diisi.',
    //     //     'greater_than' => 'Field Kapasitas harus diisi.',
    //     // ],
    //     // 'Tebal' => [
    //     //     'required' => 'Dimensi (Tebal) harus diisi.',
    //     //     'greater_than' => 'Dimensi (Tebal) harus diisi.',
    //     // ],
    //     // 'Panjang' => [
    //     //     'required' => 'Dimensi (Panjang) harus diisi.',
    //     //     'greater_than' => 'Dimensi (Panjang) harus diisi.',
    //     // ],
    //     // 'Lebar' => [
    //     //     'required' => 'Dimensi (Lebar) harus diisi.',
    //     //     'greater_than' => 'Dimensi (Lebar) harus diisi.',
    //     // ],
    //     // 'Pitch' => [
    //     //     'required' => 'Dimensi (Pitch) harus diisi.',
    //     //     'greater_than' => 'Dimensi (Pitch) harus diisi.',
    //     // ],
    //     // 'Material1' => [
    //     //     'required' => 'Field Material harus diisi.',
    //     // ],
    //     // 'TebalMat1' => [
    //     //     'required' => 'Field tebal material harus diisi.',
    //     //     'greater_than' => 'Field tebal material harus diisi.',
    //     // ],
    // ];
    protected $beforeInsert = ['typeNumEmptyValue'];
    protected $beforeUpdate = ['typeNumEmptyValue'];

    public function satuanRules($data_request)
    {

//        if( $data_request['Roll_Pcs'] && (! array_key_exists('Finishing', $data_request) || !$data_request['Finishing']) )
//        {
//            $this->setValidationRule('Finishing', 'required');
//            $this->setValidationMessage('Finishing', ['required' => 'Field Satuan (Finishing) wajib diisi']);
//        }
    }

    public function jumlahOrderRules($data_request)
    {
        if (!array_key_exists('jml', $data_request)) {
            $this->setValidationRule('jml', 'required');
            $this->setValidationMessage('jml', ['required' => 'Field Jumlah wajib diisi']);
        }
    }

    public function cekMandatory($data_request, $action)
    {

        //if (($action == 'input') || ($action == 'update') || ($action == 'estimasi')) {
        if (!$data_request['NamaProduk']) {
            $this->setValidationRule('NamaProduk', 'required');
            $this->setValidationMessage('NamaProduk', ['required' => 'Field Nama Produk wajib diisi']);

        }
        if ($data_request['NamaProduk'] == 'A') {
            $this->setValidationRule('NamaProduk', 'validTebalMat');
            $this->setValidationMessage('NamaProduk', ['validTebalMat' => 'Field Nama Produk wajib diisi']);
        }
        if (!$data_request['Pemesan']) {
            $this->setValidationRule('Pemesan', 'required');
            $this->setValidationMessage('Pemesan', ['required' => 'Field Pemesan wajib diisi']);
        }
        if (!$data_request['Segmen']) {
            $this->setValidationRule('Segmen', 'required');
            $this->setValidationMessage('Segmen', ['required' => 'Field Segmen wajib diisi']);
        }
        if (!$data_request['Konten']) {
            $this->setValidationRule('Konten', 'required');
            $this->setValidationMessage('Konten', ['required' => 'Field Konten wajib diisi']);
        }
        if (!$data_request['JenisProduk']) {
            $this->setValidationRule('JenisProduk', 'required');
            $this->setValidationMessage('JenisProduk', ['required' => 'Field Jenis Produk wajib diisi']);
        }
        if (!$data_request['Jalur']) {
            $this->setValidationRule('Jalur', 'required');
            $this->setValidationMessage('Jalur', ['required' => 'Field Jalur Pengiriman wajib diisi']);
        }
        if (!$data_request['Area']) {
            $this->setValidationRule('Area', 'required');
            $this->setValidationMessage('Area', ['required' => 'Field Area Pengiriman wajib diisi']);
        }
        if (!$data_request['Roll_Pcs']) {
            $this->setValidationRule('Roll_Pcs', 'required');
            $this->setValidationMessage('Roll_Pcs', ['required' => 'Field Satuan Roll/Pcs wajib diisi']);
        }

        //}
        if ($action == 'estimasi') {
            if (!$data_request['Lebar']) {
                $this->setValidationRule('Lebar', 'required');
                $this->setValidationMessage('Lebar', ['required' => 'Field Lebar wajib diisi']);
            }
            if (!$data_request['Panjang']) {
                $this->setValidationRule('Panjang', 'required');
                $this->setValidationMessage('Panjang', ['required' => 'Field Tinggi wajib diisi']);
            }
            if (!$data_request['Material1']) {
                $this->setValidationRule('Material1', 'required');
                $this->setValidationMessage('Material1', ['required' => 'Field Material pertama wajib diisi']);
            }
            if (!$data_request['TebalMat1']) {
                $this->setValidationRule('TebalMat1', 'required');
                $this->setValidationMessage('TebalMat1', ['required' => 'Field Tebal Material pertama wajib diisi']);
            }
            if ($data_request['TebalMat1'] == '0') {
                $this->setValidationRule('TebalMat1', 'validTebalMat');
            }
            if (!$data_request['Kapasitas']) {
                $this->setValidationRule('Kapasitas', 'required');
                $this->setValidationMessage('Kapasitas', ['required' => 'Field Kapasitas Angkut Material pertama wajib diisi']);
            }
            if ($data_request['Kapasitas'] == '0') {
                $this->setValidationRule('Kapasitas', 'validKapasitas');
            }
            if (!$data_request['JenisTinta']) {
                $this->setValidationRule('JenisTinta', 'required');
                $this->setValidationMessage('JenisTinta', ['required' => 'Field Jenis Tinta wajib diisi']);
            }
        }

    }

    public function typeNumEmptyValue(array $data)
    {
        if(isset($data['data']['Tebal']) && $data['data']['Tebal'] == '') {
            unset($data['data']['Tebal']);
        }
        if(isset($data['data']['Panjang']) && $data['data']['Panjang'] == '') {
            unset($data['data']['Panjang']);
        }
        if(isset($data['data']['Lebar']) && $data['data']['Lebar'] == '') {
            unset($data['data']['Lebar']);
        }
        if(isset($data['data']['Pitch']) && $data['data']['Pitch'] == '') {
            unset($data['data']['Pitch']);
        }
        if(isset($data['data']['TebalMat1']) && $data['data']['TebalMat1'] == '') {
            unset($data['data']['TebalMat1']);
        }
        if(isset($data['data']['TebalMat2']) && $data['data']['TebalMat2'] == '') {
            unset($data['data']['TebalMat2']);
        }
        if(isset($data['data']['TebalMat3']) && $data['data']['TebalMat3'] == '') {
            unset($data['data']['TebalMat3']);
        }
        if(isset($data['data']['TebalMat4']) && $data['data']['TebalMat4'] == '') {
            unset($data['data']['TebalMat4']);
        }
        if(isset($data['data']['Kapasitas']) && $data['data']['Kapasitas'] == '') {
            unset($data['data']['Kapasitas']);
        }
        if(isset($data['data']['Gusset']) && $data['data']['Gusset'] == '') {
            unset($data['data']['Gusset']);
        }
        if(isset($data['data']['MeterRoll']) && $data['data']['MeterRoll'] == '') {
            unset($data['data']['MeterRoll']);
        }
        if(isset($data['data']['CentreSeal']) && $data['data']['CentreSeal'] == '') {
            unset($data['data']['CentreSeal']);
        }
        if(isset($data['data']['JumlahUp']) && $data['data']['JumlahUp'] == '') {
            unset($data['data']['JumlahUp']);
        }
        if(isset($data['data']['LebarFilm']) && $data['data']['LebarFilm'] == '') {
            unset($data['data']['LebarFilm']);
        }
        if(isset($data['data']['UkuranBottom']) && $data['data']['UkuranBottom'] == '') {
            unset($data['data']['UkuranBottom']);
        }

        return $data;
    }

    public function getAlternatif()
    {
        $query = $this->selectMax('Alt')
            ->get();

        if ($query->getResult()[0]->Alt == null) {
            return 1;
        }

        return $query->getResult()[0]->Alt + 1;
    }

    public function noProspek()
    {

        return $this->datePrefix() . $this->lastIdCounter(5);
    }

    private function datePrefix()
    {
        return substr(Time::now()->getYear(), 2) . str_pad(Time::now()->getMonth(), 2, '0', STR_PAD_LEFT);
    }

    private function lastIdCounter($length)
    {
        $id = ($this->get()->getLastRow() == null) ? 0 : $this->get()->getLastRow()->NoProspek;
        $last_id = (int) substr($id, 4);
        $new_id = $last_id + 1;
        return str_pad($new_id, $length, "0", STR_PAD_LEFT);
    }

    public function getAll()
    {
        return $this->select('*')
            ->join('CustomerFile', 'MX_Prospek.Pemesan = CustomerFile.NoPemesan', 'left')
            ->join('MX_AreaKirim', 'MX_Prospek.Area = MX_AreaKirim.ID', 'left')
            ->orderBy('MX_Prospek.Created', 'desc')
            ->get();
    }

    public function getByKeyword($keyword)
    {
        $keyword_upper = strtoupper($keyword);
        $where = "MX_Prospek.Status > 0 AND (MX_Prospek.NamaProduk like '%" . $keyword . "%' OR MX_Prospek.NamaProduk like '%" . $keyword_upper . "%' OR MX_Prospek.NoProspek like '%" . $keyword . "%')";
        return $this->select('*')
            ->join('CustomerFile', 'MX_Prospek.Pemesan = CustomerFile.NoPemesan')
            ->join('MX_AreaKirim', 'MX_Prospek.Area = MX_AreaKirim.ID')
            ->where($where)
            ->get();
    }

    public function getByStatus($status, $withEstimasiList = false)
    {
        if ($withEstimasiList) {
            $where = "MX_Prospek.Status = '" . $status . "' AND MX_Prospek.Estimator IS NULL AND MX_Prospek.EstimasiUpdated IS NULL";
        } else {
            $where = "MX_Prospek.Status = " . $status;
        }
        return $this->select('MX_Prospek.*, UserPass.Nama CreatedByName, CustomerFile.NamaPemesan, convert(varchar(10), Created, 103) CreatedDate , convert(varchar(8), Created, 108) CreatedTime')
        /*
        Kolom CreatedByName = Nama Pembuat Prospek / Sales
        Kolom CreatedDate = Tanggal pembuatan format dd/mm/yyyy
        Kolom CreatedTime = Jam pembuatan format hh:mm:ss
         */

            ->join('CustomerFile', 'MX_Prospek.Pemesan = CustomerFile.NoPemesan', 'left')
            ->join('MX_AreaKirim', 'MX_Prospek.Area = MX_AreaKirim.ID', 'left')
            ->join('UserPass', 'MX_Prospek.CreatedBy=UserPass.UserID', 'left')
            ->where($where)
            ->get();
    }

    public function getByNoProspectAndAlt($NoProspek, $Alt)
    {
        return $this->where('NoProspek', $NoProspek)
            ->where('Alt', $Alt)
            ->get();
    }

    public function getDetailByNoProspectAndAlt($NoProspek, $Alt)
    {

        return $this->select('MX_Prospek.*, CustomerFile.NamaPemesan, MX_JenisProduk.nama as NamaJenisProduk, MX_Konten.Nama as NamaKonten, MX_Segmen.Nama as NamaSegmen, Mat1.Nama as NamaMaterial1, Mat2.Nama as NamaMaterial2, Mat3.Nama as NamaMaterial3, Mat4.Nama as NamaMaterial4, MX_BagMaking.Nama as NamaBagMaking, MX_AreaKirim.Nama as NamaArea, MX_Adhesive.nama Adhesive, MX_Adhesive.konstanta CoatingWeight, UserEstimator.Nama NamaEstimator, UserCreator.Nama NamaCreator')
            ->join('CustomerFile', 'MX_Prospek.Pemesan = CustomerFile.NoPemesan', 'left')
            ->join('MX_JenisProduk', 'MX_Prospek.JenisProduk = MX_JenisProduk.id', 'left')
            ->join('MX_Konten', 'MX_Prospek.Konten = MX_Konten.ID', 'left')
            ->join('MX_Segmen', 'MX_Prospek.Segmen = MX_Segmen.ID', 'left')
            ->join('MX_Adhesive', 'MX_Prospek.JenisAdhesive = MX_Adhesive.id', 'left')
            ->join('MX_Material Mat1', 'MX_Prospek.Material1 = Mat1.ID', 'left')
            ->join('MX_Material Mat2', 'MX_Prospek.Material2 = Mat2.ID', 'left')
            ->join('MX_Material Mat3', 'MX_Prospek.Material3 = Mat3.ID', 'left')
            ->join('MX_Material Mat4', 'MX_Prospek.Material4 = Mat4.ID', 'left')
            ->join('MX_BagMaking', 'MX_Prospek.BagMaking = MX_BagMaking.ID', 'left')
            ->join('MX_AreaKirim', 'MX_Prospek.Area = MX_AreaKirim.ID', 'left')
            ->join('UserPass UserEstimator', 'MX_Prospek.EstimasiUpdatedBy = UserEstimator.UserID', 'left')
            ->join('UserPass UserCreator', 'MX_Prospek.CreatedBy = UserCreator.UserID', 'left')

            ->where('MX_Prospek.NoProspek', $NoProspek)
            ->where('MX_Prospek.Alt', $Alt)
            ->get();
    }

    public function getMaxAlt($NoProspek)
    {
        return $this->selectMax('Alt')
            ->where('NoProspek', $NoProspek)
            ->get();
    }

    public function updateData($data, $NoProspek, $Alt)
    {
        return $this->where('NoProspek', $NoProspek)
            ->where('Alt', $Alt)
            ->set($data)
            ->update();
    }

    public function deleteProspek($NoProspek, $Alt)
    {
        return $this->where('NoProspek', $NoProspek)
            ->where('Alt', $Alt)
            ->delete();
    }

    public function setPriority($NoProspek, $priority = 1)
    {
        return $this->where('NoProspek', $NoProspek)
            ->set(['Prioritas' => $priority])
            ->update();
    }

    public function setRestUnpriority($NoProspek, $priority = false)
    {
        return $this->where('NoProspek !=', $NoProspek)
            ->where('Status', 10)
            ->set(['Prioritas' => $priority])
            ->update();
    }
}
