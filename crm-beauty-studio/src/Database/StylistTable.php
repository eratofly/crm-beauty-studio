<?php
declare(strict_types=1);

namespace App\Database;

use App\Common\Database\Connection;
use App\Common\Database\ConnectionProvider;
use App\Entity\Stylist;
use PDO;

class StylistTable
{
    private Connection $connection;

    public function __construct()
    {
        $this->connection = ConnectionProvider::getConnection();
    }

    public function getAllStylists(): array
    {
        $query = <<<SQL
                SELECT 
                    id, 
                    first_name,
                    last_name,
                    phone
                FROM stylist
            SQL;

        return $this->connection->execute($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStylistById(int $id): array
    {
        $query = <<<SQL
            SELECT 
                id, 
                first_name,
                last_name,
                phone
            FROM stylist
            WHERE id = $id;
        SQL;

        $stylist = $this->connection->execute($query)->fetch(PDO::FETCH_ASSOC);
        return $stylist ?: [];
    }

    public function insertStylist(Stylist $stylist): int
    {
        $arParams = [
            ':stylist_first_name' => $stylist->getFirstName(),
            ':stylist_last_name' => $stylist->getLastName(),
            ':stylist_phone' => $stylist->getPhone()
        ];

        $query = <<<SQL
            INSERT INTO stylist(first_name, last_name, phone)
            VALUES (:stylist_first_name, :stylist_last_name, :stylist_phone)                      
        SQL;

        $this->connection->execute($query, $arParams);

        return $this->connection->getLastInsertId();
    }

    public function updateStylist(Stylist $stylist): void
    {
        $id = $stylist->getId();
        $arParams = [
            ':stylist_first_name' => $stylist->getFirstName(),
            ':stylist_last_name' => $stylist->getLastName(),
            ':stylist_phone' => $stylist->getPhone()
        ];

        $query = <<<SQL
            UPDATE stylist
            SET
                first_name = :stylist_first_name,
                last_name = :stylist_last_name,
                phone = :stylist_phone
            WHERE id = $id;              
        SQL;

        $this->connection->execute($query, $arParams);
    }

    public function deleteStylist(int $id): void
    {
        $query = <<<SQL
            DELETE
            FROM stylist
            WHERE id = $id;              
        SQL;

        $this->connection->execute($query);
    }
}