<?php
declare(strict_types=1);

namespace App\Database;

use App\Common\Database\Connection;
use App\Common\Database\ConnectionProvider;
use App\Entity\Client;
use PDO;

class ClientTable
{
    private Connection $connection;

    public function __construct()
    {
        $this->connection = ConnectionProvider::getConnection();
    }

    public function getAllClients(): array
    {
        $query = <<<SQL
                SELECT 
                    id, 
                    first_name,
                    last_name,
                    phone
                FROM client
            SQL;

        return $this->connection->execute($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getClientById(int $id): array
    {
        $query = <<<SQL
            SELECT 
                id, 
                first_name,
                last_name,
                phone
            FROM client
            WHERE id = $id;
        SQL;

        $client = $this->connection->execute($query)->fetch(PDO::FETCH_ASSOC);
        return $client ?: [];
    }

    public function insertClient(Client $client): int
    {
        $arParams = [
            ':client_first_name' => $client->getFirstName(),
            ':client_last_name' => $client->getLastName(),
            ':client_phone' => $client->getPhone()
        ];

        $query = <<<SQL
            INSERT INTO client(first_name, last_name, phone)
            VALUES (:client_first_name, :client_last_name, :client_phone)                      
        SQL;

        $this->connection->execute($query, $arParams);

        return $this->connection->getLastInsertId();
    }

    public function updateClient(Client $client): void
    {
        $id = $client->getId();
        $arParams = [
            ':client_first_name' => $client->getFirstName(),
            ':client_last_name' => $client->getLastName(),
            ':client_phone' => $client->getPhone()
        ];

        $query = <<<SQL
            UPDATE client
            SET
                first_name = :client_first_name,
                last_name = :client_last_name,
                phone = :client_phone
            WHERE id = $id;              
        SQL;

        $this->connection->execute($query, $arParams);
    }
}