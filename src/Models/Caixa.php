<?php

namespace Brunosribeiro\WalletApi\Models;

use Error;
use Exception;

class Caixa
{

    public function __construct()
    {
        $this->Fechamento = null;
        $this->Rake = null;
        $this->Crupie = null;
        $this->Ativo = null;
    }

    public function setFechamento($fechamento)
    {
        $regex = '/[a-zA-Z-+]+|,/';
        if(preg_match_all($regex, $fechamento) == 1) throw new Exception('Valor inválido, insira no formato 100.00');
        if($fechamento <= 0) throw new Exception('Valor inválido, insira um valor maior que 0');
        $formattedFechamento = number_format($fechamento, '2', '.', '');
        $this->fechamento = $formattedFechamento;
        return true;
    }

    public function setRake($rake)
    {
        $regex = '/[a-zA-Z-+]+|,/';
        if(preg_match_all($regex, $rake) == 1) throw new Exception('Valor inválido, insira no formato 100.00');
        if($rake <= 0) throw new Exception('Valor inválido, insira um valor maior que 0');
        $formattedRake = number_format($rake, '2', '.', '');
        $this->rake = $formattedRake;
        return true;
    }

    public function setCrupie($crupie)
    {
        $regex = '/[a-zA-Z-+]+|,/';
        if(preg_match_all($regex, $crupie) == 1) throw new Exception('Valor inválido, insira no formato 100.00');
        if($crupie <= 0) throw new Exception('Valor inválido, insira um valor maior que 0');
        $formattedCrupie = number_format($crupie, '2', '.', '');
        $this->crupie = $formattedCrupie;
        return true;
    }
    
    public function setDataFechamento($DataFechamento)
    {
        $this->DataFechamento = $DataFechamento;
        return true;
    }
}