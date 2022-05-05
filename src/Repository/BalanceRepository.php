<?php

namespace Brunosribeiro\WalletApi\Repository;

use Brunosribeiro\WalletApi\Repository\CaixaRepository;

use Error;
use PDOException;
use PDO;


class BalanceRepository
{
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getBalanceById($id)
    {
        try{
            $query =  'SELECT users.id, 
                       users.name, 
                       users.pix, 
                       COALESCE( SUM(wallet.transactions_credit.value), 0.0) + wallet.users.saldo - (SELECT COALESCE(SUM(value), 0.0) FROM transactions_debit WHERE id_user = ?) AS value
                       FROM users 
                        LEFT JOIN transactions_credit ON users.id = transactions_credit.id_user
                        LEFT JOIN transactions_debit ON users.id = transactions_debit.id_user
                       WHERE users.id = ? AND users.deleted = 0';
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute([$id, $id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result['id'] == null) return null;
            return $result;
        } catch (PDOException $e){
            throw new Error('Erro ao consultar saldo no DB ' . $e->getMessage());
        }
    }

    public function getBalanceByIdAll()
    {
        try{
            $caixaRepo = new CaixaRepository($this->db);
            $caixa = $caixaRepo->getCaixaId();
            $query =  ' SELECT 
                        users.id, users.name, transactions_debit.id_caixa,
                        (SELECT COALESCE(SUM(value), 0.0) FROM transactions_credit WHERE id_user = users.id AND id_caixa = ?)
                           - 
                       (SELECT COALESCE(SUM(value), 0.0) FROM transactions_debit WHERE id_user = users.id AND id_caixa = ?)  AS value

                        FROM users
                        LEFT JOIN transactions_credit ON users.id = transactions_credit.id_user
                        LEFT JOIN transactions_debit ON users.id = transactions_debit.id_user

                        WHERE transactions_credit.id_caixa = ? OR transactions_debit.id_caixa = ?
                        GROUP BY users.id';
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute([$caixa, $caixa, $caixa, $caixa]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //if($result['id'] == null) return null;
            return $result;
        } catch (PDOException $e){
            throw new Error('Erro ao consultar saldo no DB ' . $e->getMessage());
        }
    }
}