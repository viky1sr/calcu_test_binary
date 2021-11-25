<?php

namespace Jakmall\Recruitment\Calculator\Repositories;
use Jakmall\Recruitment\Calculator\Repositories\StorageRepository;

class CalculatorRepository implements CalculatorRepositoryInterface{
    private $storageService;

    public function __construct(StorageRepository $storageRepository)
    {
        $this->storageService = $storageRepository;
    }

    public function add(array $inputs)
    {
        $this->storageService->historyLogComposite($inputs);
        $this->storageService->historyLogFile($inputs);
        $this->storageService->historyLogLatest($inputs);
    }

    public function divide(array $inputs)
    {
        $this->storageService->historyLogComposite($inputs);
        $this->storageService->historyLogFile($inputs);
        $this->storageService->historyLogLatest($inputs);
    }

    public function multiply(array $inputs)
    {
        $this->storageService->historyLogComposite($inputs);
        $this->storageService->historyLogFile($inputs);
        $this->storageService->historyLogLatest($inputs);
    }

    public function power(array $inputs)
    {
        $this->storageService->historyLogComposite($inputs);
        $this->storageService->historyLogFile($inputs);
        $this->storageService->historyLogLatest($inputs);
    }

    public function subtract(array $inputs)
    {
        $this->storageService->historyLogComposite($inputs);
        $this->storageService->historyLogFile($inputs);
        $this->storageService->historyLogLatest($inputs);
    }
}
