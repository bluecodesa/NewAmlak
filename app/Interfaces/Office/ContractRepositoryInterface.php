<?php


namespace App\Interfaces\Office;

interface ContractRepositoryInterface
{
    public function getAllByOfficeId($officeId);
    public function getAllByContractId($contractId);


    public function create($data);

    public function getContractById($id);

    public function updateContract($id, $data);

    public function deleteContract($id);
}
