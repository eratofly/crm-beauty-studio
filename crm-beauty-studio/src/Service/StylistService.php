<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Stylist;
use App\Database\StylistTable;
class StylistService
{
    private const DEFUALT_STYLIST_FIRST_NAME = 'First name';
    private const DEFUALT_STYLIST_LAST_NAME = 'Last name';
    private const DEFUALT_STYLIST_PHONE = '+79000000000';

    public function __construct(private StylistTable $stylistTable)
    {
    }

    /**
     * @return Stylist[]
     */
    public function stylists(): array
    {
        //TODO перенести создание объектов в класс stylistTable
        $stylists = $this->stylistTable->getAllStylists();
        foreach ($stylists as &$stylist)
        {
            $stylist = $this->getStylistFromArray($stylist);
        }
        return $stylists;
    }

    private function getStylistFromArray(array $arParams): Stylist
    {
        return new Stylist(
            $arParams['id'],
            $arParams['first_name'],
            $arParams['last_name'],
            $arParams['phone']
        );
    }

    public function getStylist(int $id)
    {
        $stylist = $this->stylistTable->getStylistById($id);
        if (!$stylist)
        {
            return null;
        }

        return $this->getStylistFromArray($stylist);
    }

    public function addStylist(): int
    {
        $stylist = new Stylist(
            null,
            self::DEFUALT_STYLIST_FIRST_NAME,
            self::DEFUALT_STYLIST_LAST_NAME,
            self::DEFUALT_STYLIST_PHONE
        );

        return $this->stylistTable->insertStylist($stylist);
    }

    public function updateStylist(int $id, string $firstName, string $lastName, string $phone): Stylist
    {
        $stylist = $this->stylistTable->getStylistById($id);;
        $stylist = $this->getStylistFromArray($stylist);

        $stylist->setFirstName($firstName);
        $stylist->setLastName($lastName);
        $stylist->setPhone($phone);

        $this->stylistTable->updateStylist($stylist);

        return $stylist;
    }

    public function deleteStylist(int $id): void
    {
        $this->stylistTable->deleteStylist($id);
    }
}