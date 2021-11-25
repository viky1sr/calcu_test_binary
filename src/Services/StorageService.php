<?php

namespace Jakmall\Recruitment\Calculator\Services;

use Jakmall\Recruitment\Calculator\Repositories\StorageRepositoryInterface;

class StorageService  {
    private $repoStorage;

    public function __construct(
        StorageRepositoryInterface $repoStorage
    )
    {
        $this->repoStorage = $repoStorage;
    }

    public function getList($command, $id, $driver)
    {
        return $this->repoStorage->getList($command,$id,$driver);
    }

    public function getListApi($command, $id, $driver)
    {
        return $this->repoStorage->getListApi($command,$id,$driver);
    }

    public function getListShowApi( $id)
    {
        return $this->repoStorage->getListShowApi($id);
    }

    public function getListDriverApi($driver)
    {
        return $this->repoStorage->getListDriverApi($driver);
    }

    public function clear($command, $id, $driver){
        return $this->repoStorage->clear($command, $id, $driver);
    }

    public function historyLogFile(array $inputs){
        return $this->repoStorage->historyLogFile($inputs);
    }

    public function historyLogLatest(array $inputs){
        return $this->repoStorage->historyLogLatest($inputs);
    }

    public function historyLogComposite(array $inputs){
        var_dump($inputs);
        return $this->repoStorage->historyLogComposite($inputs);
    }


}
