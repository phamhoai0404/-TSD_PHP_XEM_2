<?php

namespace App\Services\Domain;


use App\Entities\ControlPc;
use Illuminate\Http\Request;

class ControlPcService
{
    public function getAllControlPCs() 
    {
    	return ControlPc::all();
    }

    public function getControlPc($id)
    {
    	return ControlPc::find($id);
    }

    public function destroyControlPc($controlpc)
    {
    	return $controlpc->delete();
    }

    public function updateControlPc($controlpc, $data)
    {
    	$controlpc->fill($data)->save();
    }

    public function createControlPc($request)
    {
    	$controlpc = new ControlPc;
        $controlpc->controlpcCode = $request['controlpcCode'];
        $controlpc->ipAddress = $request['ipAddress'];
        $controlpc->note = $request['note'] ? $request['note'] : '';
        $controlpc->save();
    }
}