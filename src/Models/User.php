<?php

namespace Brunosribeiro\WalletApi\Models;

use Error;
use Exception;

class User {

    public function __construct()
    {
        $this->name = '';
        $this->piX = '';
        $this->tipo = '';
        $this->deleted = 0;
    }

    public function setName($name)
    {
        if(strlen($name) < 3) throw new Exception('Nome inválido, é necessário no mínimo 3 caracteres');
        $this->name = $name;
        return true;
    }

    public function setPiX($pi)
    {
        if(strlen($pi) < 3) throw new Exception('Pix inválido, é necessário no mínimo 3 caracteres');
        $this->pix = $pi;
        return true;
    }

    public function setDeleted($deleted)
    {
        if ($deleted == 0 || $deleted == 1) {
            $this->deleted = $deleted;
            return true;
        } else {
            throw new Exception('Parâmetro inválido ao deletar, informe true ou false');
        }
    }

    public function setTipo($tipo)
    {
        if ($tipo == 0 || $tipo == 1) {
            $this->tipo = $tipo;
            return true;
        } else {
            throw new Exception('Parâmetro inválido');
        }
    }

}