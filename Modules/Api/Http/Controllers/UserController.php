<?php

namespace Modules\Api\Http\Controllers;

use App\Services\Domain\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\Api\Http\Requests\UserRequest;
use Modules\Api\Http\Requests\UserUpdateRequest;
use Modules\Api\Http\Requests\UserResetPasswordRequest;
use App;

class UserController extends AuthApiBaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $userService;

    public function __construct(UserService $userService)
    {
        parent::__construct();

        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {       
        $data = $this->userService->getAllUsers(true);
        return $this->returnSuccess($data);
    }

    public function show($id)
    {
        $data = $this->userService->getUser($id, ['line','roles:id']);
        return $this->returnSuccess($data);
    }

    public function create(UserRequest $request) 
    {   
        $this->userService->create($request);
        return $this->returnSuccess();
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = $this->userService->getUser($id);

        if (!$this->_isValidUpdateOrDestroyUser($user)){
            return $this->returnError(__('messages.update_line_failed'));
        }
        $this->userService->updateUser($user, $request->only('note', 'depId'));
        return $this->returnSuccess();
    }

    public function destroy($id)
    {
        $user = $this->userService->getUser($id);
        if (!$this->_isValidUpdateOrDestroyUser($user)) {
            return $this->returnError(__('messages.line_failed'));
        } 
        $user = $this->userService->destroyUser($id,$user);
        return $this->returnSuccess();
    }

    public function resetPassword(UserResetPasswordRequest $request, $id) {
        $this->userService->resetPassword($id, $request['password']);
        return $this->returnSuccess();
    }

    public function getCurrentUser()
    {
        return $this->returnSuccess($this->user);
    }

    public function setLanguage(Request $request)
    {
        $this->userService->setLanguage($request, $this->user);
        return $this->returnSuccess();
    }

    private function _isValidUpdateOrDestroyUser($user){
        return (empty($user->line) || count($user->line) === 0);
    }
}