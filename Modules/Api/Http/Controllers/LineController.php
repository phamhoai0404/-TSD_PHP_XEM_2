<?php

namespace Modules\Api\Http\Controllers;

use App\Services\Domain\LineService;
use App\Services\Domain\MicroPcService;
use App\Services\Domain\DepartmentService;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Entities\Line;
use Illuminate\Http\Request;
use Modules\Api\Http\Requests\LineCreateRequest;
use Modules\Api\Http\Requests\LineUpdateRequest;

class LineController extends AuthApiBaseController
{
    protected $lineService, $microService;

    public function __construct(LineService $lineService, MicroPcService $microService, DepartmentService $departmentService)
    {
        parent::__construct();

        $this->lineService = $lineService;
        $this->microService = $microService;
        $this->departmentService = $departmentService;
    }

    public function index()
    {       
        $data = $this->lineService->getDataLine();
        return $this->returnSuccess($data);
    }
    
    public function show($id)
    {       
        $data = $this->lineService->getInfoLine($id);
        return $this->returnSuccess($data);
    }

    public function getMicrosByLineId($lineId)
    {
        $data = $this->lineService->getMicrosByLineId($lineId);
        return $this->returnSuccess($data);
    }
    
    public function getLinesByUserId($userId)
    {
        $data = $this->lineService->getLinesByUserId($userId);
        return $this->returnSuccess($data);
    }
    
    public function getLinesByDepId($depId)
    {
        $department = $this->departmentService->getInfoDepartment($depId);
        for ($i = 0; $i < count($department->users); $i++) {
            $data[$i] = $this->lineService->getLinesByUserId($department->users[$i]->id);
        }
        return $this->returnSuccess($data);
    }

    public function getMicrosByDepIdWidthLineIdNull($depId)
    {
        $data = $this->lineService->getMicrosByDepIdWidthLineIdNull($depId);
        return $this->returnSuccess($data);
    }

    public function getMicrosByDepIdWidthLineIdCurrentOrNull($depId, $lineId)
    {
        $data = $this->lineService->getMicrosByDepIdWidthLineIdCurrentOrNull($depId, $lineId);
        return $this->returnSuccess($data);
    }

    public function create(LineCreateRequest $request) 
    {
        $data = $this->lineService->createLine($request);
        if(count($request['microPC']) > 0){
            foreach ($request['microPC'] as $id) {
                if($id) {
                    $this->microService->updateLineId($id, $data->id);
                }
            }
        }
    }

    public function update(LineUpdateRequest $request, $id)
    {
        if($this->lineService->isDepartmentChanged($request['depId'], $id)){
            return $this->returnError(__('messages.line_department_fail_update'));
        }
        if ($this->lineService->isRunning($id)) {
            return $this->returnError(__('messages.line_is_running_fail_update'));
        }
        else {
            $data = $this->lineService->updateLine($request, $id);
            if(count($request['microPC']) > 0){
                foreach ($request['microPC'] as $microId) {
                    if($microId){
                        $this->microService->editMicroPCLineId($microId, $id);
                    }
                }
            }
        }
    }
    
    public function updateIsRunningForLine(Request $request, $id) {
        $data = $this->lineService->updateIsRunningForLine($id, $request->all());
        return $this->returnSuccess($data);
    }
    
    public function updateCheckedForLine(Request $request, $id) {
        $data = $this->lineService->updateCheckedForLine($id, $request);
        return $this->returnSuccess($data);
    }

    public function destroy ($id) 
    {
        if ($this->lineService->isRunning($id)) {
            return $this->returnError(__('messages.line_is_running_fail_delete'));
        }
        else {
            $data = $this->lineService->destroyLine($id);
            return $this->returnSuccess($data);
        }
    }
}