<?php

namespace Jakmall\Recruitment\Calculator\Repositories;

interface CalculatorRepositoryInterface {
    public function add(array $inputs);
    public function divide(array $inputs);
    public function power(array $inputs);
    public function subtract(array $inputs);
    public function multiply(array $inputs);
}
