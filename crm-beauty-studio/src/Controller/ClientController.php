<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Client;
use App\Service\ClientService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends AbstractController
{
    private ClientService $clientService;
    private const STYLIST_INFO_URL = '/client/info/';

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index(): Response
    {
        return $this->redirectToRoute('clients');
    }

    public function clients(): Response
    {
        $clients = $this->clientService->clients();
        foreach ($clients as &$client)
        {
            $client = $this->formatClientData($client);
        }

        return $this->render('client/list.twig', [
            'clients' => $clients
        ]);
    }

    /**
     * @throws Exception
     */

    public function infoClient(string $id)
    {
        $id = (int)$id;
        $clientInfo = $this->clientService->getClient($id);
        $clientInfo = $this->formatClientData($clientInfo);

        return $this->render('client/info.twig', [
            'client' => $clientInfo,
        ]);
    }

    public function addClient(): Response
    {
        $id = $this->clientService->addClient();

        return $this->redirect("/client/info/$id");
    }

    public function updateClient(Request $request): Response
    {
        if ($request->getMethod() !== Request::METHOD_POST) {
            return $this->redirectToRoute('clients');
        }

        $client = $this->clientService->updateClient(
            (int)$request->get('id'),
            $request->get('first_name'),
            $request->get('last_name'),
            $request->get('phone')
        );

        $id = $client->getId();
        return $this->redirect("/client/info/$id");
    }

    private function getClientInfoUrl(int $id): string
    {
        return self::STYLIST_INFO_URL . $id;
    }

    public function formatClientData(Client $client): array
    {
        return [
            'id' => $client->getId(),
            'first_name' => $client->getFirstName(),
            'last_name' => $client->getLastName(),
            'phone' => $client->getPhone(),
            'info_url' => $this->getClientInfoUrl($client->getId())
        ];
    }
}
