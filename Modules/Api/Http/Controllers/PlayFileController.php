<?php
namespace Modules\Api\Http\Controllers;

use App\Services\Domain\PlayFileService;
use Illuminate\Http\Request;

class PlayFileController extends AuthApiBaseController
{
    protected $playFileService;

    public function __construct(PlayFileService $playFileService)
    {
        parent::__construct();

        $this->playFileService = $playFileService;
    }

    public function getSourceTreeForPlayFile() {
        $data = $this->playFileService->getSourceTree();
        return $this->returnSuccess($data);
    }

    public function updateOrCreatePlaylists(Request $request) {
        $lengData = count($request->all());
        for($index = 0; $index <= $lengData; $index++) {
            $this->playFileService->updateOrCreatePlaylists($request[$index]);
        }
    }

    public function deletePlaylists(Request $request) {
        $lengData = count($request->all());
        for($index = 0; $index <= $lengData; $index++) {
            $this->playFileService->deletePlaylists($request[$index]);
        }
    }
}