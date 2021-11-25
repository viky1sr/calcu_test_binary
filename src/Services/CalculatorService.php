<?php

namespace Jakmall\Recruitment\Calculator\Services;

use Jakmall\Recruitment\Calculator\Repositories\CalculatorRepositoryInterface;

class  CalculatorService {

    private $repoCalculator;

    public function __construct(
        CalculatorRepositoryInterface $repoCalculator
    )
    {
        $this->repoCalculator = $repoCalculator;
    }


    public function add(array $inputs)
    {
        $operation = $inputs['value'];
        $find = ["+"," ",","];
        $rp = str_replace($find,"\n",$operation);
        $replace = preg_replace('/[^0-9_]+/', "\n", $rp);
        $array = explode("\n",$replace);
        $arrFilter = array_filter($array);
        $value = array_sum($arrFilter);

        $input['id'] = $inputs['id'];
        $input['result'] = $value;
        $input['command'] = 'add';
        $input['operation'] = '+';
        $input['input'] = $arrFilter;

        return $this->repoCalculator->add($input);
    }

    public function divide(array $inputs)
    {
        $operation = $inputs['value'];
        $operator = '/';
        $find = ["/"," ",","];
        $rp = str_replace($find,"\n",$operation);
        $replace = preg_replace('/[^0-9_]+/', "\n", $rp);
        $array = explode("\n",$replace);
        $arrFilter = array_filter($array);
        $value = $this->calculateAll($arrFilter,$operator);

        $input['id'] = $inputs['id'];
        $input['result'] = $value;
        $input['command'] = 'divide';
        $input['operation'] = '/';
        $input['input'] = $arrFilter;

        return $this->repoCalculator->add($input);
    }

    public function multiply(array $inputs)
    {
        $operation = $inputs['value'];
        $find = ["*"," ",","];
        $rp = str_replace($find,"\n",$operation);
        $replace = preg_replace('/[^0-9_]+/', "\n", $rp);
        $array = explode("\n",$replace);
        $arrFilter = array_filter($array);
        $value = array_product($arrFilter);

        $input['id'] = $inputs['id'];
        $input['result'] = $value;
        $input['command'] = 'multiply';
        $input['operation'] = '+';
        $input['input'] = $arrFilter;

        return $this->repoCalculator->add($input);
    }

    public function power(array $inputs)
    {
        $operation = $inputs['value'];
        $operator = '^';
        $find = ["^"," ",","];
        $rp = str_replace($find,"\n",$operation);
        $replace = preg_replace('/[^0-9_]+/', "\n", $rp);
        $array = explode("\n",$replace);
        $arrFilter = array_filter($array);
        $value = $this->calculateAll($arrFilter,$operator);

        $input['id'] = $inputs['id'];
        $input['result'] = $value;
        $input['command'] = 'power';
        $input['operation'] = '^';
        $input['input'] = $arrFilter;

        return $this->repoCalculator->add($input);
    }

    public function subtract(array $inputs)
    {
        $operation = $inputs['value'];
        $operator = '-';
        $find = ["-"," ",","];
        $rp = str_replace($find,"\n",$operation);
        $replace = preg_replace('/[^0-9_]+/', "\n", $rp);
        $array = explode("\n",$replace);
        $arrFilter = array_filter($array);
        $value = $this->calculateAll($arrFilter,$operator);

        $input['id'] = $inputs['id'];
        $input['result'] = $value;
        $input['command'] = 'subtract';
        $input['operation'] = '^';
        $input['input'] = $arrFilter;
    }


    protected function calculateAll(array $numbers,$operator)
    {
        $number = array_pop($numbers);

        if (count($numbers) <= 0) {
            return $number;
        }

        if($operator == '/' ){
            return $this->calculateDeivide($this->calculateAll($numbers,$operator), $number);
        } else if( $operator == '^'){
            return $this->calculateDeivide($this->calculatePower($numbers,$operator), $number);
        } else if($operator == '-'){
            return $this->calculateDeivide($this->calculateSubtract($numbers,$operator), $number);
        }
    }

    protected function calculateDeivide($number1, $number2)
    {
        return $number1 / $number2;
    }

    protected function calculateSubtract($number1, $number2)
    {
        return $number1 - $number2;
    }

    protected function calculatePower($number1, $number2)
    {
        return pow($number1 ,$number2);
    }
}
