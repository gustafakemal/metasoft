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
    protected $allowedFields = ['NoProspek', 'Alt', 'Tanggal', 'NamaProduk', 'Pemesan', 'Segmen', 'Konten', 'JenisProduk', 'Tebal', 'Panjang', 'Lebar', 'Pitch', 'Material1', 'TebalMat1', 'Material2', 'TebalMat2', 'Material3', 'TebalMat3', 'Material4', 'TebalMat4', 'Warna', 'Eyemark', 'RollDirection', 'Catatan', 'MaxJoin', 'WarnaTape', 'BagMaking', 'Bottom', 'OpenForFilling', 'Roll_Pcs', 'Finishing', 'Toleransi', 'Parsial', 'Keterangan', 'Area', 'Jalur', 'Kapasitas', 'Created', 'CreatedBy', 'Updated', 'UpdatedBy', 'Status', 'JenisTinta', 'JenisAdhesive', 'JenisPieces', 'Sales', 'Estimator', 'EstimasiUpdated', 'EstimasiUpdatedBy', 'EstimasiChecked', 'EstimasiCheckedBy', 'MeterRoll', 'Gusset', 'CentreSeal', 'Prioritas'];

    protected $validationRules = [
        'NamaProduk' => 'required',
        'Tebal' => 'required|greater_than[0]',
        'Panjang' => 'required|greater_than[0]',
        'Lebar' => 'required|greater_than[0]',
        'Pitch' => 'required|greater_than[0]',
        'Material1' => 'required',
        'TebalMat1' => 'required|greater_than[0]',
        'Kapasitas' => 'required|greater_than[0]',
    ];

    protected $validationMessages = [
        'NamaProduk' => [
            'required' => 'Field Nama Produk harus diisi.',
        ],
        'Kapasitas' => [
            'required' => 'Field Kapasitas harus diisi.',
            'greater_than' => 'Field Kapasitas harus diisi.',
        ],
        'Tebal' => [
            'required' => 'Dimensi (Tebal) harus diisi.',
            'greater_than' => 'Dimensi (Tebal) harus diisi.',
        ],
        'Panjang' => [
            'required' => 'Dimensi (Panjang) harus diisi.',
            'greater_than' => 'Dimensi (Panjang) harus diisi.',
        ],
        'Lebar' => [
            'required' => 'Dimensi (Lebar) harus diisi.',
            'greater_than' => 'Dimensi (Lebar) harus diisi.',
        ],
        'Pitch' => [
            'required' => 'Dimensi (Pitch) harus diisi.',
            'greater_than' => 'Dimensi (Pitch) harus diisi.',
        ],
        'Material1' => [
            'required' => 'Field Material harus diisi.',
        ],
        'TebalMat1' => [
            'required' => 'Field tebal material harus diisi.',
            'greater_than' => 'Field tebal material harus diisi.',
        ],
    ];

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

    public function getByStatus($status)
    {
        $where = "MX_Prospek.Status = " . $status;
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
        return $this->select('MX_Prospek.*, CustomerFile.NamaPemesan, MX_JenisProduk.Nama as NamaJenisProduk, MX_Konten.Nama as NamaKonten, MX_Segmen.Nama as NamaSegmen, MX_BagMaking.Nama as NamaBagMaking, MX_AreaKirim.Nama as NamaArea, MX_Adhesive.nama Adhesive')
            ->join('CustomerFile', 'MX_Prospek.Pemesan = CustomerFile.NoPemesan')
            ->join('MX_JenisProduk', 'MX_Prospek.JenisProduk = MX_JenisProduk.ID')
            ->join('MX_Konten', 'MX_Prospek.Konten = MX_Konten.ID')
            ->join('MX_Segmen', 'MX_Prospek.Segmen = MX_Segmen.ID')
            ->join('MX_BagMaking', 'MX_Prospek.BagMaking = MX_BagMaking.ID')
            ->join('MX_AreaKirim', 'MX_Prospek.Area = MX_AreaKirim.ID', 'left')
            ->join('MX_Adhesive', 'MX_Prospek.JenisAdhesive = MX_Adhesive.id', 'left')
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
