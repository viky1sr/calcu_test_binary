<?php

namespace Jakmall\Recruitment\Calculator\Http\Controller;

use http\Client\Response;
use Illuminate\Http\Request;
use Jakmall\Recruitment\Calculator\Services\CalculatorService;
use Jakmall\Recruitment\Calculator\Services\StorageService;

class CalculatorController
{
    private $calculatorService;
    private $storageService;

    public function __construct(
        CalculatorService $calculatorService,
        StorageService $storageService

    )
    {
        $this->calculatorService = $calculatorService;
        $this->storageService = $storageService;
    }

    public function calculate(Request $request, $action = "")
    {
        $inputs = [
            'id' => uniqid(),
            'value' => $request->value
        ];

        if($action == "add"){
            $this->calculatorService->add($inputs);
            $driver = "";
            $id = $inputs['id'];
            sleep(2);
            $res = $this->storageService->getListApi($action,$id,$driver);
            return $res;

        } elseif ($action == "divide"){
            $this->calculatorService->divide($inputs);
            $driver = "";
            $id = $inputs['id'];
            sleep(2);
            $res = $this->storageService->getListApi($action,$id,$driver);
            return $res;
        } elseif ($action == "power"){
            $this->calculatorService->power($inputs);
            $driver = "";
            $id = $inputs['id'];
            sleep(2);
            $res = $this->storageService->getListApi($action,$id,$driver);
            return $res;
        } elseif ($action == "subtract"){
            $this->calculatorService->subtract($inputs);
            $driver = "";
            $id = $inputs['id'];
            sleep(2);
            $res = $this->storageService->getListApi($action,$id,$driver);
            return $res;
        } elseif ($action == "multiply") {
            $this->calculatorService->multiply($inputs);
            $driver = "";
            $id = $inputs['id'];
            sleep(2);
            $res = $this->storageService->getListApi($action,$id,$driver);
            return $res;
        }
    }

}
