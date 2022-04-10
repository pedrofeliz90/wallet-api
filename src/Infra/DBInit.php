<?php

namespace Brunosribeiro\WalletApi\Infra;

class iniciaDB
{
    public function __construct($db)
    {
        $this->db = $db;
    }

    private $querys = [
        'CREATE TABLE IF NOT EXISTS caixa (
            Id INT AUTO_INCREMENT,
            DataAbertura TIMESTAMP NOT NULL DEFAULT current_timestamp,
            DataFechamento TIMESTAMP NULL DEFAULT current_timestamp ON UPDATE current_timestamp(),
            Fechamento varchar(20) NOT NULL,
            Rake varchar(20) NOT NULL,
            Crupie varchar(20) NOT NULL,
            Ativo int(11) NOT NULL
            PRIMARY KEY (id)
        );',
        'CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT,
            name varchar(240) NOT NULL,
            nickname varchar(240) NOT NULL UNIQUE,
            deleted boolean,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        );',
        'CREATE TABLE IF NOT EXISTS transactions_credit (
            id INT AUTO_INCREMENT,
            id_user INT NOT NULL,
            type varchar(240) NOT NULL,
            value decimal(65,2),
            id_caixa INT(11) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY(id_user) REFERENCES users (id),
            FOREIGN KEY(id_caixa) REFERENCES caixa (id)
        );',    

        'CREATE TABLE IF NOT EXISTS transactions_debit  (
            id INT AUTO_INCREMENT,
            id_user INT NOT NULL,
            type varchar(240) NOT NULL,
            value decimal(65,2),
            id_caixa INT(11) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY(id_user) REFERENCES users (id),
            FOREIGN KEY(id_caixa) REFERENCES caixa (id)
        );', 
    
        'INSERT INTO caixa (Id, DataAbertura, DataFechamento, Fechamento, Rake, Crupie, Ativo) VALUES
            (1, "2022-04-09 09:00:53", "2022-04-09 09:25:05", "19990.00", "192.00", "218.00", 0),
            (2, "2022-04-09 09:25:36", "2022-04-09 09:36:12", "200.00", "13.00", "5.00", 0);
        ',
        'INSERT INTO users (id, name, nickname, deleted) VALUES
            (1, "Bruno", "brunoribeiro", 0),
            (2, "Bruce", "batman", 1),
            (3, "Walter White", "Heisenberg", 0),
            (4, "User test API", "usertesteapi", 0),
            (5, "Teste sem saldo", "testesemsaldo", 0),
            (6, "Teste saldo negativo", "saldonegativo", 0);
        ',
        'INSERT INTO transactions_credit(id_user, type, value, id_caixa) VALUES
            (1, "entrada", 500.00, 1),
            (1, "entrada", 380.00, 1),
            (1, "entrada", 220.50, 1),
            (2, "entrada", 180.75, 1),
            (2, "entrada", 197.55, 1),
            (2, "entrada", 1052.80, 2),
            (3, "entrada", 875.75, 2),
            (3, "entrada", 982.90, 2);
        ',
        'INSERT INTO transactions_debit (id_user, type, value, id_caixa) VALUES
            (1, "saida", 375.45, 1),
            (1, "saida", 15.98, 1),
            (2, "saida", 285.95, 1),
            (2, "saida", 52.87, 2),
            (6, "saida", 100.89, 2),
            (3, "saida", 10.99, 2),
            (3, "saida", 87.45, 2);
        '
    ];

    private function cadastraDB()
    {
        foreach($this->querys as $query){
            $this->db->get()->exec($query);
        }
    }

    public function iniciaDB()
    {
        $tableExists = $this->db->get()->query("SHOW TABLES LIKE 'users'")->rowCount() > 0;
        if(!$tableExists) $this->cadastraDB();
    }
}



