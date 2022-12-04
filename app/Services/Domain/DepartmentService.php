<?php
/**
 * Created by PhpStorm.
 * Department: longta
 * Date: 2019/03/14
 * Time: 16:50
 */

namespace App\Services\Domain;


use App\Entities\Department;
use App\Entities\User;

class DepartmentService
{
    public function getUserInfoByDepId($depId)
    {
        return User::where('depId', $depId)->get();
    }

    public function getInfoDepartment($deId)
    {
        return Department::find($deId);
    }
}