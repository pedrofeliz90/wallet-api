<?php

namespace Brunosribeiro\WalletApi\Services;

use Brunosribeiro\WalletApi\Repository\CaixaRepository;
use Error;
use Exception;

class CaixaServices
{
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function MostrarCaixas()
    {
        try{
            $caixaRepo = new CaixaRepository($this->db);
            $result = $caixaRepo->MostrarCaixas();
            return $result;
        } catch (Error $e) {
            throw new Error($e);
        }
    }


    public function abrircaixa()
    {
        try{
            $caixaRepo = new CaixaRepository($this->db);
            $caixaRepo->abrircaixa();
            return true;
        } catch (Error $error) {
            throw new Error($error);
        }
    }

    public function fecharcaixa($caixa)
    {
        try{
            $caixa = (array) $caixa;
            $caixaRepo = new CaixaRepository($this->db);
            $result = $caixaRepo->fecharcaixa($caixa);
            return $result;
        } catch (Error $error){
            throw new Error($error);
        }
    }
}