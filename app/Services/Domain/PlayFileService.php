<?php

namespace App\Services\Domain;

use Illuminate\Support\Facades\Auth;
use App\Entities\PlayList;
use App\Entities\File;
use App\Entities\Department;

class PlayFileService
{
    public function getSourceTree() {
        if(Auth::user()->roles[0]->name == USER_ROLE_ADMIN){
            $depCodes = Department::pluck('depCode')->all();
            return File::whereIn('depCode', $depCodes)->get();
        } else {
            $depId = Auth::user()->depId;
            $department = Department::find($depId);
            return File::where('depCode', $department->depCode)->get();
        }
    }

    public function createPlaylists($data) {
        if($data['id']) {
            $setting = [];
            if($data['file']) {
                $lengFile = count($data['file']);
                for($indexFile = 0; $indexFile < $lengFile ;$indexFile++) {
                    if($data['file'][$indexFile]['title']) {
                        $file = File::where('fileName', $data['file'][$indexFile]['title'])->first();
                        $setting[$indexFile]['id'] = $file->id;
                        $lengStime = count($data['file'][$indexFile]['s_time']);
                        for($indexStime=0; $indexStime< $lengStime; $indexStime++) {
                            $setting[$indexFile]['config'][$indexStime] = $data['file'][$indexFile]['s_time'][$indexStime];
                        }
                    }
                }
                if(count($setting)>0) {
                    $playLists['micropcId'] = $data['id'];
                    $playLists['setting'] = json_encode($setting);
                    return PlayList::create($playLists);
                }
            }
        }
    }

    public function updatePlaylists($data) {
        if($data['id']) {
            $playLists = PlayList::where('micropcId', $data['id'])->first();
            $setting = [];
            if($data['file']) {
                $lengFile = count($data['file']);
                for($indexFile = 0; $indexFile < $lengFile ;$indexFile++) {
                    if($data['file'][$indexFile]['title']) {
                        $file = File::where('fileName', $data['file'][$indexFile]['title'])->first();
                        $setting[$indexFile]['id'] = $file->id;
                        $lengStime = count($data['file'][$indexFile]['s_time']);
                        for($indexStime=0; $indexStime< $lengStime; $indexStime++) {
                            $setting[$indexFile]['config'][$indexStime] = $data['file'][$indexFile]['s_time'][$indexStime];
                        }
                    } else {
                        $playLists->delete();
                    }
                }
                if(count($setting)>0) {
                    $playLists['micropcId'] = $data['id'];
                    if($playLists && json_encode($setting) != $playLists['setting']) {
                        $playLists['setting'] = json_encode($setting);
                        $playLists->save();
                    }
                }
            }
        }
    }

    public function updateOrCreatePlaylists($data) {
        $playLists = PlayList::where('micropcId', $data['id'])->get();
        if(count($playLists) == 0) {
            $this->createPlaylists($data);
        } else {
            $this->updatePlaylists($data);
        }
    }

    public function deletePlaylists($data) {
        $playList = PlayList::where('micropcId', $data['id'])->first();
        if($data['id'] && $playList) {
            $playList->delete();
        }
    }
}
