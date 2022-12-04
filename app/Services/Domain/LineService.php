<?php
/**
 * Created by PhpStorm.
 * User: longta
 * Date: 2019/03/14
 * Time: 16:50
 */

namespace App\Services\Domain;


use App\Entities\Line;
use App\Entities\MicroPC;
use App\Entities\Department;
use App\Entities\File;
use Illuminate\Support\Facades\Auth;

class LineService
{
    public function getDataLine() {
        return Line::with(['user.department'])->get();
    }

    public function getInfoLine($id) {
        return Line::find($id);
    }

    public function getLinesByUserId($userId) {
        return Line::where('userId',$userId)->get();
    }

    public function getMicrosByLineId($lineId) {
        $microPcs = MicroPC::orderBy('microCode', 'asc')->where('lineId', $lineId)->with(['playfile'])->get();
        $arrFile = [];
        $lengMicroPC = count($microPcs);
        for($indexMicro = 0 ; $indexMicro < $lengMicroPC; $indexMicro++) {
            if($microPcs[$indexMicro]['playfile']) {
                $setting[$indexMicro] = json_decode($microPcs[$indexMicro]['playfile']->setting, true);
                $arrIdFile = [];
                for($indexSetting = 0; $indexSetting < count($setting[$indexMicro]); $indexSetting++) {
                    array_push($arrIdFile, $setting[$indexMicro][$indexSetting]['id']);
                }
                $placeholders = implode(',',array_fill(0, count($arrIdFile), '?')); // string for the query
                $microPcs[$indexMicro]->file = File::whereIn('id', $arrIdFile)->orderByRaw("field(id,{$placeholders})", $arrIdFile)->get();
            }
        }
        return $microPcs;
    }

    public function getMicrosByDepIdWidthLineIdNull($depId) {
        return MicroPC::whereNull('lineId')->where('depId',$depId)->get();
    }

    public function getMicrosByDepIdWidthLineIdCurrentOrNull($depId, $lineId) {
        return MicroPC::where([
                                ['lineId', $lineId],
                                ['depId',$depId]
                            ])
                            ->orWhere([
                                ['lineId', null],
                                ['depId',$depId]
                            ])
                            ->get();
    }

    public function createLine($data) {
        $newLine = Line::create($data->only('lineCode', 'userId', 'note'));
        return $newLine;
    }

    public function updateLine($data, $id) {
        $line = $this->getInfoLine($id);
        $line->fill($data->only('lineCode', 'note', 'userId'))->save();
    }

    public function updateIsRunningForLine($id, $data) {
        $line = $this->getInfoLine($id);
        if($line->isRunning != $data['isRunning']) {
            $line->isRunning = $data['isRunning'];
        }
        $line->save();
    }

    public function updateCheckedForLine($id, $data) {
        $line = $this->getInfoLine($id);
        $line->isSetting = $data['isChecked'];
        $data['isChecked'] ? $line->lockByUser = Auth::user()->userCode : $line->lockByUser = null;
        $line->save();
    }

    public function destroyLine($id) {
        $line = $this->getInfoLine($id);
        $micropc = MicroPC::where('lineId', $id)->get();
        for($index = 0; $index < count($micropc); $index++) {
            if($micropc[$index]) {
                $micropc[$index]->lineId = null;
                $micropc[$index]->save();
            }
        }
        $line->delete();
    }

    public function isRunning($id){
        $line = $this->getInfoLine($id);
        return ($line->isRunning);
    }

    public function isDepartmentChanged($depId, $id){
        $line = $this->getInfoLine($id);
        return $line->user->department->id = $depId ? false : true;
    }
}
