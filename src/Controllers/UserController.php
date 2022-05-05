<?php

namespace Brunosribeiro\WalletApi\Controllers;

use Brunosribeiro\WalletApi\Infra\DBConnection;
use Brunosribeiro\WalletApi\Models\User;
use Brunosribeiro\WalletApi\Services\UserServices;
use Brunosribeiro\WalletApi\Services\CaixaServices;
use Error;
use Exception;

class UserController
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

    public function getAllUsers()
    {
        try{
            $userServices = new UserServices($this->db);
            $getUsers = $userServices->getAllUsers();
            return json_encode(['success' => $getUsers]);
        } catch (Error $error) {
            echo $error;
            return json_encode(['error' => 'Erro ao buscar todos os usuários.']);
        }
    }

    public function getUserById($id)
    {   
        try{
            $userServices = new UserServices($this->db);
            $getUser = $userServices->getUserById($id);
            return json_encode(['success' => $getUser]);
        } catch (Error $error) {
            return json_encode(['error' => 'Erro ao buscar usuário por ID.']);
        } catch (Exception $exception) {
            return json_encode(['warning' => $exception->getMessage()]);
        }
    }

    public function getUserByTipo($tipo)
    {   
        try{
            $userServices = new UserServices($this->db);
            $getUser = $userServices->getUserByTipo($tipo);
            return json_encode(['success' => $getUser]);
        } catch (Error $error) {
            return json_encode(['error' => 'Erro ao buscar usuário por Tipo.']);
        } catch (Exception $exception) {
            return json_encode(['warning' => $exception->getMessage()]);
        }
    }

    public function getUserBypix($pix)
    {
        try{
            $userServices = new UserServices($this->db);
            $getUser = $userServices->getUserBypix($pix);
            return json_encode(['success' => $getUser]);
        } catch (Error $error) {
            return json_encode(['error' => 'Erro ao buscar usuário por pix.']);
        } catch (Exception $exception) {
            return json_encode(['warning' => $exception->getMessage()]);
        }
    }

    public function getUserByName($name)
    {
        try{
            $userServices = new UserServices($this->db);
            $getUser = $userServices->getUserByName($name);
            return json_encode(['success' => $getUser]);
        } catch (Error $error) {
            return json_encode(['error' => 'Erro ao buscar usuário por nome.']);
        } catch (Exception $exception) {
            return json_encode(['warning' => $exception->getMessage()]);
        }
    }

    public function addUser($params)
    {
        try{
            $userServices = new UserServices($this->db);
            $user = new User();
            $user->setName($params['name']);
            $user->setPix($params['pix']);
            $user->setTipo($params['tipo']);
            $userServices->addUser($user);
            return json_encode(['success' => 'Usuário adicionado com sucesso']);
        } catch (Error $error) {
            if(strpos($error, 'Duplicate entry')) {
                return json_encode(['warning' => 'Usuário já cadastrado, tente com outro pix.']);
            } else {
                return json_encode(['error' => 'Erro ao cadastrar usuário']);
            }
        } catch (Exception $exception) {
            return json_encode(['warning' => $exception->getMessage()]);
        }
    }

    public function editUser($id, $data)
    {
        try{
            $userServices = new UserServices($this->db);
            $user = new User();
            $user->setName($data['name']);
            $user->setPix($data['pix']);
            $userServices->editUserById($id, $user);
            return json_encode(['success' => 'Usuário editado com sucesso']);
        } catch (Error $error) {
            if(strpos($error, 'Duplicate entry')) {
                return json_encode(['warning' => 'Usuário já cadastrado, tente com outro pix.']);
            } else {
                return json_encode(['error' => 'Erro ao editar usuário']);
            }
        } catch (Exception $exception) {
            return json_encode(['warning' => $exception->getMessage()]);
        }
    }

    public function deleteUser($id)
    {
        try{
            $userServices = new UserServices($this->db);
            $userServices->deleteUserById($id);
            return json_encode(['success' => 'Usuário excluído com sucesso.']);
        } catch (Error $error) {
            return json_encode(['error' => 'Erro ao excluir usuário.']);
        }
    }
}