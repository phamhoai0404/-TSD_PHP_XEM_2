<?php

namespace Modules\Api\Http\Controllers;

use App\Entities\Department;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Entities\MicroPC;
use Modules\Api\Http\Requests\MicroPCRequest;
use App\Services\Domain\MicroPcService;
use Modules\Api\Http\Requests\MicroPCUpdateRequest;
use App\Services\Domain\LineService;

class MicroPCController extends AuthApiBaseController
{
    protected $microPcService, $lineService;

    public function __construct(MicroPcService $microPcService, LineService $lineService)
    {
        parent::__construct();

        $this->microPcService = $microPcService;
        $this->lineService = $lineService;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $micro_pcs = $this->microPcService->getAllMicroPC(['department:id,depCode','line:id,lineCode']);
        return $this->returnSuccess($micro_pcs);
    }

    public function store(MicroPCRequest $request)
    {
        $this->microPcService->create($request);
        return $this->returnSuccess();
    }

    public function update(MicroPCUpdateRequest $request, $id)
    {
        $micro = $this->microPcService->getMicroPc($id);
            if($micro->isRunning) {
                return $this->returnError(__('messages.micro_edit_failed'));
            }
            if($micro->lineId !== null && $micro->depId !== $request['depId'] && $micro->depId !== null) {
                return $this->returnError(__('messages.micro_edit_failed_dep'));
            }
        $this->microPcService->updateMicroPC($id, $request->only('depId', 'microCode','note','ipAddress'));
        return $this->returnSuccess();
    }
    
    public function updateIsRunningForMicroPC(Request $request) {
        $this->microPcService->updateIsRunning($request->all());
        return $this->returnSuccess();
    }
    
    public function destroy($id)
    {
        $micro = $this->microPcService->getMicroPc($id);
        if($micro->isRunning) {
            return $this->returnError(__('messages.micro_failed'));
        } else {
            $this->microPcService->destroyMicroPc($id);
            return $this->returnSuccess();
        }
    }

    public function shutdownById($id) {
        $micro = $this->microPcService->getMicroPc($id);
        $plink = env('PUTTY_BIN');
        $ipAddress = $micro['ipAddress'];
        $password = env('PI_PASSWORD');
        exec("\"$plink\" -ssh pi@$ipAddress -pw $password sudo halt");
        return $this->returnSuccess();
    }

    public function rebootById($id) {
        $micro = $this->microPcService->getMicroPc($id);
        $plink = env('PUTTY_BIN');
        $ipAddress = $micro['ipAddress'];
        $password = env('PI_PASSWORD');
        exec("\"$plink\" -ssh pi@$ipAddress -pw $password sudo reboot");

        return $this->returnSuccess();
    }

}
