<?php
/**
 * Created by PhpStorm.
 * User: longta
 * Date: 2019/03/14
 * Time: 16:50
 */

namespace App\Services\Domain;


use App\Entities\User;
use Illuminate\Http\Request;
use Modules\Api\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;


class UserService
{
    public function getAllUsers($isGetRole = false){
        $users = User::with(['department:id,depCode'])->get();

        if($isGetRole){
            foreach ($users as $user) {
                $user->roleName = $user->getRoleNames();
            }
        }

        return $users;
    }

    public function create($request)
    {
        $user = new User;
        $user->userCode = $request['userCode'];
        $user->password = bcrypt($request['password']);
        $user->depId = $request['depId'];
        $user->note = $request['note'] ? $request['note'] : '';
        $user->save();
        $user->assignRole($request['roleId']);
    }

    public function updateUser($user, $data){
        $user->fill($data)->save();
    } 

    public function getUser($id, $withData = ''){
        if(empty($withData)){
            return User::find($id);
        } else {
            return User::with($withData)->find($id);
        } 
    }

    public function resetPassword($id, $newPassword){
        $user = User::find($id);
        $user->password = bcrypt($newPassword);
        $user->save();
    }

    public function destroyUser($id,$user){     
        $role = $user->getRoleNames();
        if (count($role) > 0 ) {
            $user->removeRole($role[0]);
        }
        $user->delete();
    }

    public function setLanguage($request, $user) {
        $user->language = $request['language'];
        $user->save();
    }

}