<?php
/**
 * Created by PhpStorm.
 * User: longta
 * Date: 2019/03/04
 * Time: 11:03
 */

namespace Modules\Api\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Domain\SettingService;

class SettingController extends AuthApiBaseController
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        parent::__construct();

        $this->settingService = $settingService;
    }

    public function getSetting($name)
    {
        $data = $this->settingService->getSetting($name);
        return $this->returnSuccess($data);
    }

    public function getAllSettings()
    {
        $data = $this->settingService->getAllSettings();
        return $this->returnSuccess($data);
    }

    public function update(Request $request)
    {
        $errors = [];
        for ($index = 0; $index < count($request->name); $index++ ) {
            if ($this->_isValidUpdateSetting($request,$index)) {
                if($request->name[$index] === DESTINATION_PATH && !file_exists($request->value[$index]) || $request->name[$index] === SOURCE_PATH && !file_exists($request->value[$index])) {
                    if($request->name[$index] === DESTINATION_PATH && !file_exists($request->value[$index])) {
                        $errors[$index] = __('messages.destination_path_not_exists');
                    }
                    if($request->name[$index] === SOURCE_PATH && !file_exists($request->value[$index])) {
                        $errors[$index] = __('messages.source_path_not_exists');
                    }
                } else {
                    $this->settingService->updateSetting($request->name[$index], $request->value[$index]);
                }
            } else {
                $errors[$index] = __('messages.error_setting');
            }
        }
        if(count($errors) > 0){
            return $this->returnError($errors);
        }
        return $this->returnSuccess();
    }

    private function _isValidUpdateSetting($request,$index)
    {
        return ($request->value[$index]);
    }
}