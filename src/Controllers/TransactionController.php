<?php

namespace Brunosribeiro\WalletApi\Controllers;

use Brunosribeiro\WalletApi\Infra\DBConnection;
use Brunosribeiro\WalletApi\Models\Transaction;
use Brunosribeiro\WalletApi\Services\TransactionServices;
use Brunosribeiro\WalletApi\Repository\CaixaRepository;
use Error;
use Exception;

class TransactionController
{

    public function __construct()
    {   
        $this->db = new DBConnection(
            $_ENV['DB_HOST'],
            $_ENV['DB_DATABASE'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASS']
        );
    }

    public function addTransactionCredit($params)
    {
        try{
            $transactionServices = new TransactionServices($this->db);
            $transaction = new Transaction();
            $transaction->setType('entrada');
            $transaction->setIdUser($params['id_user']);
                $caixaRepo = new CaixaRepository($this->db);
                $caixa = $caixaRepo->getCaixaId();
            $transaction->setIdCaixa($caixa);            
            $transaction->setValue($params['value']);
            $transaction->$params['situacao'];
            $transactionServices->addTransactionCredit($transaction);
            return json_encode(['success' => 'Transação registrada com sucesso!']);
        } catch (Error $error) {
            return json_encode(['error' => 'Erro ao adicionar transação de crédito.']);
        } catch (Exception $exception) {
            return json_encode(['warning' => $exception->getMessage()]);
        }
    }

    public function addTransactionDebit($params)
    {
        try{
            $transactionServices = new TransactionServices($this->db);
            $transaction = new Transaction();
            $transaction->setType('saida');
            $transaction->setIdUser($params['id_user']);
                $caixaRepo = new CaixaRepository($this->db);
                $caixa = $caixaRepo->getCaixaId();
            $transaction->setIdCaixa($caixa);            
            $transaction->setValue($params['value']);
            $transaction->$params['situacao'];
            $transactionServices->addTransactionDebit($transaction);
            return json_encode(['success' => 'Transação registrada com sucesso!']);
        } catch (Error $error) {
            return json_encode(['error' => 'Erro ao adicionar transação de débito.']);
        } catch (Exception $exception) {    
            return json_encode(['warning' => $exception->getMessage()]);
        }
    }

    public function addTransactionCrupie($params)
    {
        try{
            $transactionServices = new TransactionServices($this->db);
            $transaction = new Transaction();
            $transaction->setIdUser($params['id_user']);
                $caixaRepo = new CaixaRepository($this->db);
                $caixa = $caixaRepo->getCaixaId();
            $transaction->setIdCaixa($caixa);            
            $transaction->setValue($params['value']);
            $transactionServices->addTransactionCrupie($transaction);
            return json_encode(['success' => 'Transação registrada com sucesso!']);
        } catch (Error $error) {
            return json_encode(['error' => 'Erro ao adicionar transação de crédito.']);
        } catch (Exception $exception) {
            return json_encode(['warning' => $exception->getMessage()]);
        }
    }

        public function getTransactionDebit()
    {
        try{
            $transactionServices = new TransactionServices($this->db);
            $getTransactions = $userServices->getTransactionDebit();
            return json_encode(['success' => $getTransactions]);
        } catch (Error $error) {
            echo $error;
            return json_encode(['error' => 'Erro ao buscar todos os usuários.']);
        }
    }

        public function getTransactionCredit()
    {
        try{
            $transactionServices = new TransactionServices($this->db);
            $getTransactions = $transactionServices->getTransactionCredit();
            return json_encode(['success' => $getTransactions]);
        } catch (Error $error) {
            echo $error;
            return json_encode(['error' => 'Erro ao buscar todos os usuários.']);
        }
    }
}