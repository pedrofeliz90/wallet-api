<?php

namespace Brunosribeiro\WalletApi\Services;

use Brunosribeiro\WalletApi\Repository\BalanceRepository;
use Brunosribeiro\WalletApi\Repository\UserRepository;
use Error;
use Exception;

class BalanceServices
{
    public function __construct($db)
    {   
        $this->db = $db;
    }

    public function getBalanceById($id)
    {
        try{
            $balanceRepo = new BalanceRepository($this->db);
            $result = $balanceRepo->getBalanceById($id);
            if($result == null) throw new Exception('Usuário não encontrado');
            return $result;
        } catch (Error $error) {
            throw new Error($error);
        }
    }

    public function getBalanceByIdAll()
    {
        try{
            $balanceRepo = new BalanceRepository($this->db);
            $result = $balanceRepo->getBalanceByIdAll();
            if($result == null) throw new Exception('Sem Movimento');
            return $result;
        } catch (Error $error) {
            throw new Error($error);
        }
    }
}