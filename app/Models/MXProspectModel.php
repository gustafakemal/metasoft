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
    protected $allowedFields = ['NoProspek', 'Alt', 'Tanggal', 'NamaProduk', 'Pemesan', 'Segmen', 'Konten', 'JenisProduk', 'Tebal', 'Panjang', 'Lebar', 'Pitch', 'Material1', 'TebalMat1', 'Material2', 'TebalMat2', 'Material3', 'TebalMat3', 'Material4', 'TebalMat4', 'Warna', 'Eyemark', 'RollDirection', 'Catatan', 'MaxJoin', 'WarnaTape', 'BagMaking', 'Bottom', 'OpenForFilling', 'Jumlah', 'Roll_Pcs', 'Finishing', 'Toleransi', 'Parsial', 'Keterangan', 'Area', 'Jalur', 'Kapasitas', 'Created', 'CreatedBy', 'Updated', 'UpdatedBy'];

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
        'NamaProduk'        => [
            'required' => 'Field Nama Produk harus diisi.',
        ],
        'Kapasitas'        => [
            'required' => 'Field Kapasitas harus diisi.',
            'greater_than' => 'Field Kapasitas harus diisi.',
        ],
        'Tebal'        => [
            'required' => 'Dimensi (Tebal) harus diisi.',
            'greater_than' => 'Dimensi (Tebal) harus diisi.',
        ],
        'Panjang'        => [
            'required' => 'Dimensi (Panjang) harus diisi.',
            'greater_than' => 'Dimensi (Panjang) harus diisi.',
        ],
        'Lebar'        => [
            'required' => 'Dimensi (Lebar) harus diisi.',
            'greater_than' => 'Dimensi (Lebar) harus diisi.',
        ],
        'Pitch'        => [
            'required' => 'Dimensi (Pitch) harus diisi.',
            'greater_than' => 'Dimensi (Pitch) harus diisi.',
        ],
        'Material1'        => [
            'required' => 'Field Material harus diisi.',
        ],
        'TebalMat1'        => [
            'required' => 'Field tebal material harus diisi.',
            'greater_than' => 'Field tebal material harus diisi.',
        ],
    ];

    public function getAlternatif()
    {
        $query = $this->selectMax('Alt')
                        ->get();

        if($query->getResult()[0]->Alt == null) {
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
        $last_id = (int)substr($id, 4);
        $new_id = $last_id + 1;
        return str_pad($new_id, $length, "0", STR_PAD_LEFT);
    }

    public function getByKeyword($keyword)
    {
        return $this->select('*')
                    ->join('CustomerFile', 'MX_Prospek.Pemesan = CustomerFile.NoPemesan')
                    ->like('MX_Prospek.NamaProduk', $keyword)
                    ->get();
    }

    public function getByNoProspect($NoProspek)
    {
        return $this->where('NoProspek', $NoProspek)
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
}