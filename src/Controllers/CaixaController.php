<?php

namespace Brunosribeiro\WalletApi\Controllers;

use Brunosribeiro\WalletApi\Infra\DBConnection;
use Brunosribeiro\WalletApi\Models\Caixa;
use Brunosribeiro\WalletApi\Services\CaixaServices;
use Error;
use Exception;

class CaixaController
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

    public function abrircaixa()
    {
        try{
            $caixaServices = new CaixaServices($this->db);
            $caixaServices->abrircaixa();
            return json_encode(['success' => 'Caixa aberto com sucesso!']);
        } catch (Error $error) {
            return json_encode(['error' => 'Erro ao abrir o caixa.']);
        } catch (Exception $exception) {
            return json_encode(['warning' => $exception->getMessage()]);
        }
    }

    public function fecharcaixa($params)
    {
        try{
            $caixaServices = new CaixaServices($this->db);
            $caixa = new Caixa();
            $caixa->setFechamento($params['fechamento']);
            $caixa->setRake($params['rake']);
            $caixa->setCrupie($params['crupie']);
            $caixaServices->fecharcaixa($caixa);
            return json_encode(['success' => 'Caixa Fechado com Sucesso!']);
        } catch (Error $error) {
            return json_encode(['error' => 'Erro ao fechar o caixa.']);
        } catch (Exception $exception) {    
            return json_encode(['warning' => $exception->getMessage()]);
        }
    }

    public function MostrarCaixas()
    {
        try{
            $caixaServices = new CaixaServices($this->db);
            $getCaixas = $caixaServices->MostrarCaixas();
            return json_encode(['success' => $getCaixas]);
        } catch (Error $error) {
            echo $error;
            return json_encode(['error' => 'Erro ao buscar todos os caixas.']);
        }
    }
}