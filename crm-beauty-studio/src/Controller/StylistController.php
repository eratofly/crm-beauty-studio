<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Stylist;
use App\Service\StylistService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StylistController extends AbstractController
{
    private StylistService $stylistService;
    private const STYLIST_INFO_URL = '/stylist/info/';
    private const STYLIST_DELETE_URL = '/stylist/delete/';

    public function __construct(StylistService $stylistService)
    {
        $this->stylistService = $stylistService;
    }

    public function index(): Response
    {
        return $this->redirectToRoute('stylists');
    }

    public function showStylistsList(): Response
    {
        $stylists = $this->stylistService->stylists();
        foreach ($stylists as &$stylist)
        {
            $stylist = $this->formatStylistData($stylist);
        }

        return $this->render('stylist/list.twig', [
            'stylists' => $stylists
        ]);
    }

    /**
     * @throws Exception
     */

    public function showStylistForm(string $id)
    {
        $id = (int)$id;
        $stylistInfo = $this->stylistService->getStylist($id);
        $stylistInfo = $this->formatStylistData($stylistInfo);

        return $this->render('stylist/info.twig', [
            'stylist' => $stylistInfo,
        ]);
    }

    public function addStylist(): Response
    {
        $id = $this->stylistService->addStylist();

        return $this->redirect("/stylist/info/$id");
    }

    public function deleteStylist(string $id): Response
    {
        $id = (int)$id;
        $this->stylistService->deleteStylist($id);
        return $this->redirectToRoute('stylists');
    }

    public function updateStylist(Request $request): Response
    {
        if ($request->getMethod() !== Request::METHOD_POST) {
            return $this->redirectToRoute('stylists');
        }

        $stylist = $this->stylistService->updateStylist(
            (int)$request->get('id'),
            $request->get('first_name'),
            $request->get('last_name'),
            $request->get('phone')
        );

        $id = $stylist->getId();
        return $this->redirect("/stylist/info/$id");
    }

    private function getStylistInfoUrl(int $id): string
    {
        return self::STYLIST_INFO_URL . $id;
    }

    private function getStylistDeleteUrl(int $id): string
    {
        return self::STYLIST_DELETE_URL . $id;
    }

    public function formatStylistData(Stylist $stylist): array
    {
        return [
            'id' => $stylist->getId(),
            'first_name' => $stylist->getFirstName(),
            'last_name' => $stylist->getLastName(),
            'phone' => $stylist->getPhone(),
            'info_url' => $this->getStylistInfoUrl($stylist->getId()),
            'delete_url' => $this->getStylistDeleteUrl($stylist->getId())
        ];
    }
}
