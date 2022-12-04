<?php
/**
 * Created by PhpStorm.
 * User: longta
 * Date: 2019/03/04
 * Time: 11:03
 */

namespace Modules\Api\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Entities\ControlPc;
use Modules\Api\Http\Requests\ControlPcRequest;
use Modules\Api\Http\Requests\ControlPcUpdateRequest;
use App\Services\Domain\ControlPcService;

class ControlPcController extends AuthApiBaseController
{
    protected $controlpcService;

    public function __construct(ControlPcService $controlpcService)
    {
        parent::__construct();

        $this->controlpcService = $controlpcService;
    }

    public function index()
    {
    	$data = $this->controlpcService->getAllControlPCs();
        return $this->returnSuccess($data);
    }


    public function destroy($id)
    {
        $controlpc = $this->controlpcService->getControlPc($id);
        $controlpc = $this->controlpcService->destroyControlPc($controlpc);
        return $this->returnSuccess();
    }

    public function create(ControlPcRequest $request)
    {
        $data = $this->controlpcService->createControlPc($request);
        return $this->returnSuccess($data);
    }

    public function update(ControlPcUpdateRequest  $request, $id)
    {
        $controlpc = $this->controlpcService->getControlPc($id);
        $this->controlpcService->updateControlPc($controlpc, $request->only('controlpcCode', 'ipAddress', 'note'));
        return $this->returnSuccess();
    }
}