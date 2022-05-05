<?php

namespace Brunosribeiro\WalletApi\Repository;

use Error;
use PDO;
use PDOException;

class UserRepository
{
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function addUser($user)
    {
        try{
            $query = 'INSERT INTO users (name, pix, deleted, tipo) VALUES (?,?,?,?)';
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute([$user->name, $user->pix, $user->deleted, $user->tipo]);
            return true;
        } catch(PDOException $e){
            throw new Error('Erro ao adicionar usuário no DB ' . $e->getMessage());
        }
    }


    public function editUserById($id, $data)
    {
        try{
            $columns = [];
            if (count($data) < 2 ) {
                $columns = implode(',', array_keys($data)) . " = ?";
                $values = array_values($data);
            } else {
                $columns = implode(' = ? , ', array_keys($data));
                $columns = $columns . " = ?";
                $values = array_values($data);
            }
            array_push($values, $id);
            $query = "UPDATE users SET " . $columns . " WHERE id = ?";
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute($values);
            return true;
        } catch(PDOException $e){
            throw new Error('Erro ao editar usuário no DB ' . $e->getMessage());
        }
    }

    public function getAllUsers()
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

    public function getUserById($id)
    {
        try{
            $query = 'SELECT id, name, pix FROM users WHERE id = ? AND deleted = 0';
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result == null) return null;
            return $result;
        } catch(PDOException $e){
            throw new Error('Erro ao buscar o usuário por ID no DB ' . $e->getMessage());
        }
    }

    public function getUserByTipo($tipo)
    {
        try{
            $query = 'SELECT id, name, pix FROM users WHERE tipo = ? AND deleted = 0';
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute([$tipo]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($result == null) return null;
            return $result;
        } catch(PDOException $e){
            throw new Error('Erro ao buscar o usuário por Tipo no DB ' . $e->getMessage());
        }
    }

    public function getUserBypix($pi)
    {
        try{
            $query = 'SELECT id, name, pix FROM users WHERE pix = ? AND deleted = 0';
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute([$pi]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result == null) return null;
            return $result;
        } catch (PDOException $e) {
            throw new Error('Erro ao buscar o usuário por pix no DB ' . $e->getMessage());
        }
    }

    public function getUserByName($name)
    {
        try{
            $query = 'SELECT id, name, pix FROM users WHERE name = ? AND deleted = 0';
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute([$name]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($result == null) return null;
            return $result;
        } catch (PDOException $e) {
            throw new Error('Erro ao buscar o usuário por nome no DB ' . $e->getMessage());
        }
    }

    public function deleteUserById($id)
    {
        try{
            $query = 'UPDATE users SET deleted = 1 WHERE id = ?';
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            throw new Error('Erro ao exclur usuário por ID no DB ' . $e->getMessage());
        }
    }
}