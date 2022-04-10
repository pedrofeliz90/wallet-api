<?php

namespace Brunosribeiro\WalletApi\Repository;

use Error;
use PDO;
use PDOException;

class CaixaRepository
{
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function MostrarCaixas()
    {
        try{
            $query = 'SELECT Id, DataAbertura, DataFechamento, Rake, Crupie, Ativo FROM caixa';
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch(PDOException $e){
            throw new Error('Erro ao buscar todos os caixas no DB ' . $e->getMessage());
        }
    }  
    
    public function abrircaixa()
    {
        try{
            $query = 'INSERT INTO caixa (Ativo, DataFechamento) VALUES (1, null)';
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute();
            return true;
        } catch(PDOException $e){
            throw new Error('Erro ao abrir caixa no DB ' . $e->getMessage());
        }
    }

    public function fecharcaixa($caixa)
    {
        try{
            $columns = [];
            if (count($caixa) < 2 ) {
                $columns = implode(',', array_keys($caixa)) . " = ?";
                $values = array_values($caixa);
            } else {
                $columns = implode(' = ? , ', array_keys($caixa));
                $columns = $columns . " = ?";
                $values = array_values($caixa);
            }
            array_push($caixa);
            $query = "UPDATE caixa SET " . $columns . " WHERE Ativo = 1";
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute($values);
            return true;
        } catch(PDOException $e){
            throw new Error('Erro ao fechar caixa no DB ' . $e->getMessage());
        }
    }

    public function getCaixaId()
    {
        try{
            $query = 'SELECT id FROM caixa WHERE Ativo = 1';
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($result == null) return 'Nao ha caixa aberto.';
            return $result[0]['id'];
        } catch(PDOException $e){
            throw new Error('Erro ao buscar o Caixa por ID no DB ' . $e->getMessage());
        }
    }
}