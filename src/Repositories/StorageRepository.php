<?php

namespace Jakmall\Recruitment\Calculator\Repositories;

use Monolog\Formatter\JsonFormatter;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class StorageRepository implements StorageRepositoryInterface {

    public function getList($command, $id, $driver) : array
    {
        if($driver == 'file') {
            $path = 'storage/File/mesinhitung.log';
            $nameDrive = 'File';
        } else if($driver == 'latest'){
            $path = 'storage/Latest/latest.log';
            $nameDrive = 'Latest';
        } else {
            $path = 'storage/Composite/composite.log';
            $nameDrive = 'Composite';
        }

        $fdata = file_get_contents($path);
        $stringArr = explode("\n", $fdata);
        $tampung = [];

        foreach($stringArr as $key => $value){
            $encode = json_decode($value);
            if($encode != null){
                $tampung[] = $encode;
            }
        }

        $new_array = array_filter($tampung, function($obj) use ($command, $id){

            if($command == null && $id == null) {
                return true;
            }

            if($id != null && $command != null){
                if(in_array($obj->command, [$command]) && in_array($obj->id, [$id])) {
                    return true;
                }
            } else {
                if($command != null){
                    if(in_array($obj->command, [$command])) {
                        return true;
                    }
                }else if($id != null){
                    if(in_array($obj->id, [$id])) {
                        return true;
                    }
                }
            }

        });

        $newArray = array_map(function($data) use ($nameDrive) {
            return [
                $data->id,
                ucfirst($data->command),
                $data->operation,
                implode($data->operation,$data->input),
                $data->result,
                $nameDrive
            ];
        }, $new_array);

        return $newArray;

    }

    public function getListApi($command, $id, $driver) : array
    {
        if($driver == 'file') {
            $path = 'storage/File/mesinhitung.log';
            $nameDrive = 'File';
        } else if($driver == 'latest'){
            $path = 'storage/Latest/latest.log';
            $nameDrive = 'Latest';
        } else {
            $path = 'storage/Composite/composite.log';
            $nameDrive = 'Composite';
        }

        $fdata = file_get_contents($path);
        $stringArr = explode("\n", $fdata);
        $tampung = [];

        foreach($stringArr as $key => $value){
            $encode = json_decode($value);
            if($encode != null){
                $tampung[] = $encode;
            }
        }

        $new_array = array_filter($tampung, function($obj) use ($command, $id){

            if($command == null && $id == null) {
                return true;
            }

            if($id != null && $command != null){
                if(in_array($obj->command, [$command]) && in_array($obj->id, [$id])) {
                    return true;
                }
            } else {
                if($command != null){
                    if(in_array($obj->command, [$command])) {
                        return true;
                    }
                }else if($id != null){
                    if(in_array($obj->id, [$id])) {
                        return true;
                    }
                }
            }

        });

        $newArray = array_map(function($data) use ($nameDrive) {
            return [
                "ID" => $data->id,
                "Command" => ucfirst($data->command),
                "Operation" => implode($data->operation,$data->input),
                "Result" => $data->result,
            ];
        },$new_array);

        return $newArray;

    }

    public function getListShowApi($id ) : array
    {
        $path = 'storage/File/mesinhitung.log';
        $fdata = file_get_contents($path);
        $stringArr = explode("\n", $fdata);
        $tampung = [];

        foreach($stringArr as $key => $value){
            $encode = json_decode($value);
            if($encode != null){
                $tampung[] = $encode;
            }
        }

        $new_array = array_filter($tampung, function($obj) use ( $id){

            if($id == null) {
                return true;
            }

            if($id != null) {
                if (in_array($obj->id, [$id])) {
                    return true;
                }
            }

        });

        $newArray = array_map(function($data)  {
            return [
                "ID" => $data->id,
                "Command" => ucfirst($data->command),
                "Operation" => implode($data->operation,$data->input),
                "Result" => $data->result,
            ];
        },$new_array);

        return $newArray;

    }

    public function getListDriverApi($driver) : array
    {
        if($driver == 'file') {
            $path = 'storage/File/mesinhitung.log';
            $fdata = file_get_contents($path);
            $stringArr = explode("\n", $fdata);
        }

        if($driver == 'latest'){
            $path = 'storage/Latest/latest.log';
            $fdata = file_get_contents($path);
            $stringArr = explode("\n", $fdata);
        }
        if($driver == 'composite') {
            $path = 'storage/Composite/composite.log';
            $fdata = file_get_contents($path);
            $stringArr = explode("\n", $fdata);
        }

        if($driver == "[file|latest|composite]" || $driver == "[latest|file|composite]" || $driver == "[composite|file|latest]"
            || $driver == "[latest|composite|file]"
        ){
            $path_1 = 'storage/Composite/composite.log';
            $fdata_1 = file_get_contents($path_1);
            $stringArr_1 = explode("\n", $fdata_1);
            $path_2 = 'storage/Latest/latest.log';
            $fdata_2 = file_get_contents($path_2);
            $stringArr_2 = explode("\n", $fdata_2);
            $path_3 = 'storage/File/mesinhitung.log';
            $fdata_3 = file_get_contents($path_3);
            $stringArr_3 = explode("\n", $fdata_3);
            $stringArr =  array_merge($stringArr_1,$stringArr_2,$stringArr_3);
        } else if($driver == "[file|latest]"||$driver == "[latest|file]"){
            $path_2 = 'storage/Latest/latest.log';
            $fdata_2 = file_get_contents($path_2);
            $stringArr_2 = explode("\n", $fdata_2);
            $path_3 = 'storage/File/mesinhitung.log';
            $fdata_3 = file_get_contents($path_3);
            $stringArr_3 = explode("\n", $fdata_3);
            $stringArr =  array_merge($stringArr_2,$stringArr_3);
        } else if($driver == "[latest|composite]" || $driver == "[composite|latest]"){
            $path_1 = 'storage/Composite/composite.log';
            $fdata_1 = file_get_contents($path_1);
            $stringArr_1 = explode("\n", $fdata_1);
            $path_2 = 'storage/Latest/latest.log';
            $fdata_2 = file_get_contents($path_2);
            $stringArr_2 = explode("\n", $fdata_2);
            $stringArr =  array_merge($stringArr_1,$stringArr_2);
        }else if($driver == "[file|composite]" || $driver == "[composite|file]"){
            $path_1 = 'storage/Composite/composite.log';
            $fdata_1 = file_get_contents($path_1);
            $stringArr_1 = explode("\n", $fdata_1);
            $path_3 = 'storage/File/mesinhitung.log';
            $fdata_3 = file_get_contents($path_3);
            $stringArr_3 = explode("\n", $fdata_3);
            $stringArr =  array_merge($stringArr_1,$stringArr_3);
        }

        $tampung = [];
        foreach($stringArr as $key => $value){
            $encode = json_decode($value);
            if($encode != null){
                $tampung[] = $encode;
            }
        }

        $newArray = array_map(function($data) {
            return [
                "ID" => $data->id,
                "Command" => ucfirst($data->command),
                "Operation" => implode($data->operation,$data->input),
                "Result" => $data->result,
            ];
        },$tampung);

        return $newArray;

    }

    public function clear($command, $id, $driver)
    {
        if($driver == 'file') {
            $path = 'storage/File/mesinhitung.log';
        } else if($driver == 'latest'){
            $path = 'storage/Latest/latest.log';
        } else {
            $path = 'storage/Composite/composite.log';
        }

        $fdata = file_get_contents($path);
        $stringArr = explode("\n", $fdata);
        $newData = [];

        foreach($stringArr as $key => $value){
            $encode = json_decode($value);
            if($encode != null){
                if($encode->command == $command && $encode->id == $id ){
                    unset($encode);
                }else if($encode->command == $command && $encode->id == null){
                    unset($encode);
                } else if ($encode->id == $id){
                    unset($encode);
                } else if($encode->id == null && $encode->command == null){
                    unset($encode);
                } else {
                    $newData[] = $value;
                }
            }
        }
        file_put_contents($path,implode("\n",$newData));
    }

    public function historyLogFile(array $inputs)
    {
        $path = 'storage/File/mesinhitung.log';
        $logger = new Logger('add');
        $logstream = new StreamHandler($path, Logger::INFO);
        $output = "%context%\n";
        $formatter = new LineFormatter($output);
        $logstream->setFormatter($formatter, new JsonFormatter());
        $logger->pushHandler($logstream);

        $logger->pushProcessor(function ($record) use($inputs) {
            $record['context'] = [
                'id' => $inputs['id'],
                'command' => $inputs['command'],
                'operation' => $inputs['operation'],
                'input' => $inputs['input'],
                'result' => $inputs['result'],
            ];
            return $record;
        });
        $logger->info('Calculator');
    }

    public function historyLogLatest(array $inputs)
    {
        $path = 'storage/Latest/latest.log';
        $logger = new Logger('add');
        $logstream = new StreamHandler($path, Logger::INFO);
        $output = "%context%\n";
        $formatter = new LineFormatter($output);
        $logstream->setFormatter($formatter, new JsonFormatter());
        $logger->pushHandler($logstream);

        $logger->pushProcessor(function ($record) use($inputs) {
            $record['context'] = [
                'id' => $inputs['id'],
                'command' => $inputs['command'],
                'operation' => $inputs['operation'],
                'input' => $inputs['input'],
                'result' => $inputs['result'],
            ];
            return $record;
        });
        $logger->info('Calculator');
    }

    public function historyLogComposite(array $inputs)
    {
        $path = 'storage/Composite/composite.log';
        $logger = new Logger('add');
        $logstream = new StreamHandler($path, Logger::INFO);
        $output = "%context%\n";
        $formatter = new LineFormatter($output);
        $logstream->setFormatter($formatter, new JsonFormatter());
        $logger->pushHandler($logstream);

        $logger->pushProcessor(function ($record) use($inputs) {
            $record['context'] = [
                'id' => $inputs['id'],
                'command' => $inputs['command'],
                'operation' => $inputs['operation'],
                'input' => $inputs['input'],
                'result' => $inputs['result'],
            ];
            return $record;
        });
        $logger->info('Calculator');
    }

}
