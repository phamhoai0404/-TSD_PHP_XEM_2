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
use App\Entities\Department;
use Modules\Api\Http\Requests\DepartmentRequest;
use Modules\Api\Http\Requests\DepartmentUpdateRequest;
use App\Services\Domain\DepartmentService;

class DepartmentController extends AuthApiBaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $depService;

    public function __construct(DepartmentService $depService)
    {
        parent::__construct();

        $this->depService = $depService;
    }

    public function index()
    {
    	$data = Department::all();
        return $this->returnSuccess($data);
    }

    public function getUserByDepId($depId)
    {
        $data = $this->depService->getUserInfoByDepId($depId);
        return $this->returnSuccess($data);
    }

    public function getDepWidthRoleLine($depId)
    {
        $data = $this->depService->getInfoDepartment($depId);
        return $this->returnSuccess($data);
    }

    public function destroy($id)
    {
        $department = Department::find($id);
        $user = $department->users;
        if(count($user) === 0){
            $department->delete();
        } else {
            return $this->returnError(__('messages.department_user_faild'));
        }
    }

    public function create(DepartmentRequest $request)
    {
        $department = new Department;
        $department->depCode = $request['depCode'];
        $department->depName = $request['depName'];
        $department->note = $request['note'] ? $request['note'] : '';
        $department->save();
        return $this->returnSuccess();
    }

    public function update(DepartmentUpdateRequest  $request, $id)
    {
        $department = Department::find($id);
        $department->fill($request->only('depName', 'note'))->save();
        return $this->returnSuccess();
    }
}