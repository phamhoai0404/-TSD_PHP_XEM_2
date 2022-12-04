<?php
/**
 * Created by PhpStorm.
 * User: longta
 * Date: 2019/03/14
 * Time: 16:50
 */

namespace App\Services\Domain;


use App\Entities\MicroPC;
use App\Entities\Line;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MicroPcService
{
    public function getMicroPc($id, $withData = '')
    {
        if(!empty($withData)){
            return MicroPC::with($withData)->find($id);
        } else {
            return MicroPC::find($id);
        } 
    }

    public function getAllMicroPC($withData = '')
    {
        if(!empty($withData)) {
            return MicroPC::with($withData)->get();
        }
        else {
            return MicroPC::all();
        }
    }

    public function create($request)
    {
        MicroPC::create($request->all());
    }

    public function destroyMicroPc($id)
    {
        $micro = MicroPC::find($id);
        $micro->delete();
    }

    public function updateMicroPC($id, $data)
    {
        $micro = MicroPC::find($id);
        $micro->fill($data)->save();
    }

    public function updateIsRunning($data)
    {
        $micros = MicroPC::whereIn('microCode', $data['microCodes'])->get();
        foreach ($micros as $micro) {
            $micro->isRunning = $data['isRunning'];
            $micro->save();
        }
    }

    public function updateLineId($id, $lineId)
    {
        $micro = MicroPC::find($id);
        $micro->lineId = $lineId;
        $micro->save();
    }

    public function editMicroPCLineId($microId, $lineId)
    {
        $micro = MicroPC::find($microId);
        $micro->lineId = $micro->lineId ? null : $lineId;
        $micro->save();
    }
}