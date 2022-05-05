<?php

namespace Brunosribeiro\WalletApi\Controllers;

use Brunosribeiro\WalletApi\Services\ExtractServices;
use Brunosribeiro\WalletApi\Infra\DBConnection;
use Error;
use Exception;

class ExtractController
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

    public function getLastDaysById($params)
    {
        try{
            $extractServices = new ExtractServices($this->db);
            $result = $extractServices->lastDaysById($params['id'], $params['days']);
            return json_encode(['success' => $result]);
        } catch (Error $error) {
            return json_encode(['error' => 'Erro ao consultar extrato.']);
        } catch (Exception $exception) {
            return json_encode(['warning' => $exception->getMessage()]);
        }
    }

    public function getPerPeriodById($params)
    {
        try{
            $extractServices = new ExtractServices($this->db);
            $result = $extractServices->perPeriodById($params['id'], $params['initialDate'], $params['finalDate']);
            return json_encode(['success' => $result]);
        } catch (Error $error) {
            return json_encode(['error' => 'Erro ao consultar extrato.']);
        } catch (Exception $exception) {
            return json_encode(['warning' => $exception->getMessage()]);
        }
    }

    public function getPerCaixa($params)
    {
        try{
            $extractServices = new ExtractServices($this->db);
            $result = $extractServices->perCaixa($params['id'], $params['id_caixa']);
            return json_encode($result);
        } catch (Error $error) {
            return json_encode('Erro ao consultar extrato.');
        } catch (Exception $exception) {
            return json_encode($exception->getMessage());
        }
    }

            public function getAllTransaction()
    {
        try{
            $extractServices = new ExtractServices($this->db);
            $getExtract = $extractServices->getAllTransaction();
            return json_encode(['success' => $getExtract]);
        } catch (Error $error) {
            echo $error;
            return json_encode(['error' => 'Erro ao buscar todos os usuários.']);
        }
    }
}