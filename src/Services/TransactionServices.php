<?php

namespace Brunosribeiro\WalletApi\Services;

use Brunosribeiro\WalletApi\Repository\BalanceRepository;
use Brunosribeiro\WalletApi\Repository\TransactionRepository;
use Brunosribeiro\WalletApi\Repository\UserRepository;
use Brunosribeiro\WalletApi\Repository\CaixaRepository;
use Error;
use Exception;

class TransactionServices
{
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function addTransactionCredit($transaction)
    {
        try{
            $userRepo = new UserRepository($this->db);
            $user = $userRepo->getUserById($transaction->id_user);
            if($user == null) throw new Exception('Usuário não encontrado');
            $transactionRepo = new TransactionRepository($this->db);
            $result = $transactionRepo->addTransactionCredit($transaction);
            return $result;
        } catch (Error $error){
            throw new Error($error);
        }
    }

    public function addTransactionDebit($transaction)
    {
        try{
            $userRepo = new UserRepository($this->db);
            $user = $userRepo->getUserById($transaction->id_user);
            if($user == null) throw new Exception('Usuário não encontrado');
            $transactionRepo = new TransactionRepository($this->db);
            $result = $transactionRepo->addTransactionDebit($transaction);
            return $result;
        } catch (Error $error){
            throw new Error($error);
        }
    }

    public function addTransactionCrupie($transaction)
    {
        try{
            $userRepo = new UserRepository($this->db);
            $user = $userRepo->getUserById($transaction->id_user);
            if($user == null) throw new Exception('Usuário não encontrado');
            $transactionRepo = new TransactionRepository($this->db);
            $result = $transactionRepo->addTransactionCrupie($transaction);
            return $result;
        } catch (Error $error){
            throw new Error($error);
        }
    }

        public function getTransactionDebit()
    {
        try{
            $transactionRepo = new TransactionRepository($this->db);
            $result = $transactionRepo->getTransactionDebit();
            return $result;
        } catch (Error $e) {
            throw new Error($e);
        }
    }

        public function getTransactionCredit()
    {
        try{
            $transactionRepo = new TransactionRepository($this->db);
            $result = $transactionRepo->getTransactionCredit();
            return $result;
        } catch (Error $e) {
            throw new Error($e);
        }
    }
    /*public function addTransactionDebit($transaction)
    {
        try{
            $userRepo = new UserRepository($this->db);
            $user = $userRepo->getUserById($transaction->id_user);
            if($user == null) throw new Exception('Usuário não encontrado');
            $balanceRepo = new BalanceRepository($this->db);
            $balance = $balanceRepo->getBalanceById($transaction->id_user);
            if($balance['saldo'] < $transaction->value) throw new Exception('Transação negada! Seu saldo é insuficiente para essa transação. Saldo atual: R$' . $balance['saldo']);
            $transactionRepo = new TransactionRepository($this->db);
            $result = $transactionRepo->addTransactionDebit($transaction);
            return $result;
        } catch (Error $error){
            throw new Error($error);
        }
    }*/
}