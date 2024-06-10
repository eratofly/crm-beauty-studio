<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Client;
use App\Database\ClientTable;

class ClientService
{
    private ClientTable $clientTable;
    private const DEFUALT_CLIENT_FIRST_NAME = 'First name';
    private const DEFUALT_CLIENT_LAST_NAME = 'Last name';
    private const DEFUALT_CLIENT_PHONE = '+79000000000';

    public function __construct(ClientTable $clientTable)
    {
        $this->clientTable = $clientTable;
    }

    /**
     * @return Client[]
     */
    public function clients(): array
    {
        $clients = $this->clientTable->getAllClients();
        foreach ($clients as &$client)
        {
            $client = $this->getClientFromArray($client);
        }
        return $clients;
    }

    public function getClient(int $id)
    {
        $client = $this->clientTable->getClientById($id);
        if (!$client)
        {
            return null;
        }

        return $this->getClientFromArray($client);
    }

    public function addClient(): int
    {
        $client = new Client(
            null,
            self::DEFUALT_CLIENT_FIRST_NAME,
            self::DEFUALT_CLIENT_LAST_NAME,
            self::DEFUALT_CLIENT_PHONE
        );

        return $this->clientTable->insertClient($client);
    }

    public function updateClient(int $id, string $firstName, string $lastName, string $phone): Client
    {
        $client = $this->clientTable->getClientById($id);;
        $client = $this->getClientFromArray($client);

        $client->setFirstName($firstName);
        $client->setLastName($lastName);
        $client->setPhone($phone);

        $this->clientTable->updateClient($client);

        return $client;
    }

    private function getClientFromArray(array $arParams): Client
    {
        return new Client(
            $arParams['id'],
            $arParams['first_name'],
            $arParams['last_name'],
            $arParams['phone']
        );
    }
}