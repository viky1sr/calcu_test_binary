<?php

namespace Jakmall\Recruitment\Calculator\Repositories;

interface StorageRepositoryInterface {

    public function clear($command, $id, $driver);
    public function historyLogFile(array $inputs);
    public function historyLogLatest(array $inputs);
    public function historyLogComposite(array $inputs);
    public function getList($command, $id, $driver);
    public function getListApi($command, $id, $driver);
    public function getListShowApi($id);
    public function getListDriverApi($driver);

}
