<?php

namespace Brunosribeiro\WalletApi\Repository;

use Error;
use PDOException;
use PDO;

class TransactionRepository
{

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function addTransactionCredit($transaction)
    {
        try{
            $query = 'INSERT INTO transactions_credit (id_user, type, value, id_caixa) VALUES (?, ?, ?, ?)';
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute([$transaction->id_user, $transaction->type, $transaction->value, $transaction->id_caixa]);
            return true;
        } catch (PDOException $e){
            throw new Error('Erro ao adicionar transação de crédito no DB ' . $e->getMessage());
        }
    }

    public function addTransactionDebit($transaction)
    {
        try{
            $query = 'INSERT INTO transactions_debit (id_user, type, value, id_caixa) VALUES (?, ?, ?, ?)';
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute([$transaction->id_user, $transaction->type, $transaction->value, $transaction->id_caixa]);
            return true;
        } catch (PDOException $e){
            throw new Error('Erro ao adicionar transação de débito no DB ' . $e->getMessage());
        }
    }

    public function addTransactionCrupie($transaction)
    {
        try{
            $query = 'INSERT INTO transactions_crupie (id_user, value, id_caixa) VALUES (?, ?, ?)';
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute([$transaction->id_user, $transaction->value, $transaction->id_caixa]);
            return true;
        } catch (PDOException $e){
            throw new Error('Erro ao adicionar transação de crédito no DB ' . $e->getMessage());
        }
    }

        public function getTransactionDebit()
    {
        try{
            $query = 'SELECT id, name, pix, saldo, tipo FROM users WHERE deleted = 0';
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch(PDOException $e){
            throw new Error('Erro ao buscar todos os usuários no DB ' . $e->getMessage());
        }
    }

        public function getTransactionCredit()
    {
        try{
            $query = 'SELECT id, name, pix, saldo, tipo FROM users WHERE deleted = 0';
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch(PDOException $e){
            throw new Error('Erro ao buscar todos os usuários no DB ' . $e->getMessage());
        }
    }
}