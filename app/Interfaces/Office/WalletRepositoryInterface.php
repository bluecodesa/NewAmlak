<?php


namespace App\Interfaces\Office;

interface WalletRepositoryInterface
{
    public function getAllByOfficeId($officeId);

    public function create($data);

    public function getById($id);

    public function updateWallet($id, $data);

    public function deleteWallet($id);
}
