<?php

namespace Modules\Api\Http\Controllers;

use App\Entities\File;
use App\Services\Domain\SettingService;

class DownloadFileController extends UnAuthApiBaseController
{
	private $destinationPath;

	public function __construct(SettingService $settingService) {
        parent::__construct();

        $this->destinationPath = $settingService->getSetting('destination_path');
    }
    public function download($id) {
        try {
            $fileInfo = File::find($id);
            if($fileInfo && $fileInfo->id == $id) {
                $path_file = $this->destinationPath."/".$fileInfo->customer."/".$fileInfo->model."/".$fileInfo->version."/".$fileInfo->depCode."/".$fileInfo->fileName;
                if(!file_exists($path_file)) {
                    return $this->returnError(__('messages.path_file_not_exists'));
                } else {
                    return $this->returnSuccess(chunk_split(base64_encode(file_get_contents($path_file))));
                }
            } else {
                return $this->returnError(__('messages.id_file_not_exists'));
            }
        } catch (Throwable $e) {
            return $this->returnError($e->getMessage());
        }
    }
}