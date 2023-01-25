<?php

namespace App\Controllers;

class MXCekModel extends BaseController
{
    private $modelBankData;

    public function __construct()
    {
        $this->modelBankData = new \App\Models\MXBankDataModel();
    }

    /**
     * @return string
     */
    public function index(): string
    {
        $jenisproduk = 45;
        $testBankData = $this->modelBankData->getByJenisProduk($jenisproduk);
        dd($testBankData);
    }

    public function getBankData(): string
    {
        $jenisproduk = 45;
        $testBankData = $this->modelBankData->getByJenisProduk($jenisproduk);
        dd($testBankData->getResult());
    }

}
