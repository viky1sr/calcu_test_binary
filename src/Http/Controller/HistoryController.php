<?php

namespace Jakmall\Recruitment\Calculator\Http\Controller;

use Illuminate\Http\Request;
use Jakmall\Recruitment\Calculator\Services\StorageService;

class HistoryController
{
    private $storageService;

    public function __construct(
        StorageService $storageService

    )
    {
        $this->storageService = $storageService;
    }

    public function index(Request $request)
    {
//        dd($request->all());
        $data = $request->all();
        if ( isset($data['driver']) ) {
            $driver = $data['driver'];
            $res = $this->storageService->getListDriverApi($driver);
            return $res;
        }
    }

    public function show($id)
    {
        $command = "";
        $driver = "";
        if($id != null) {
            $res = $this->storageService->getListShowApi($command , $id , $driver);
            return $res;
        } else {
            return 'Not found';
        }
    }

    public function remove($id)
    {
        $command = "";
        $driver = "";
        if($id != null) {
            $res = $this->storageService->clear($command , $id , $driver);
            return "Success delete";
        } else {
            return 'Not found';
        }
    }
}
