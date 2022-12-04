<?php

namespace Modules\Api\Http\Controllers;

use App\Services\Inf\FileService;
use App\Services\Domain\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Exception;

class SyncFileController extends AuthApiBaseController
{
    protected $fileService;
    private $sourcePath;
    private $destinationPath;

    public function __construct(FileService $fileService, SettingService $settingService) {
        parent::__construct();
        $this->fileService = $fileService;
        $this->sourcePath = $settingService->getSetting(SOURCE_PATH);
        $this->destinationPath = $settingService->getSetting(DESTINATION_PATH);
    }

    function getAllDepartments() {
        $depCode = DB::table('departments')->pluck('depCode')->all();
        return $this->returnSuccess($depCode);
    }

    public function getSourceTree() {
        $sourceFiles = $this->fileService->getDirContents($this->sourcePath);
        return $this->returnSuccess($sourceFiles);
    }

    public function getDesTree() {
        $desFiles = $this->fileService->getDirContents($this->destinationPath);
        return $this->returnSuccess($desFiles);
    }

    public function deleteItemInTree(Request $request) {
        $itemPath = $request['itemPath'];
        if (strpos($itemPath, $this->sourcePath) !== false ) {
            // Delete in source tree
            try {
                if (is_file($itemPath)) {
                    unlink($itemPath);
                } else {
                    $this->fileService->removeAllHiddenFilesAndFolders($itemPath);
                    $this->fileService->clearContentOfFolder($itemPath, false);
                }
            } catch (Throwable $e) {
                return $this->returnError(__('messages.sync_file_tree_delete_exception'), $e->getMessage());
            }
        } else {
            // Delete in destination tree
            DB::beginTransaction();
            try {
                $result = $this->fileService->deleteFilesOnDbFromTree($itemPath, $this->destinationPath);
                if ($result == NORMALLY_DONE) {
                    // Delete on disk
                    if (is_file($itemPath)) {
                        unlink($itemPath);
                    } else {
                        $this->fileService->removeAllHiddenFilesAndFolders($itemPath);
                        $this->fileService->clearContentOfFolder($itemPath, false);
                    }
                } else if ($result == ERROR_INVALID_PATH) {
                    DB::rollBack();
                    return $this->returnError(__('messages.sync_file_tree_delete_invalid_path'));
                } else { // ERROR_FILE_USING
                    DB::rollBack();
                    return $this->returnError(__('messages.sync_file_tree_delete_using_file'));
                }
            } catch (Throwable $e) {
                DB::rollBack();
                return $this->returnError(__('messages.sync_file_tree_delete_exception'), $e->getMessage());
            }
            DB::commit();
        }
        return $this->returnSuccess();
    }

    public function renameItemInTree(Request $request) {
        $itemPath = $request['itemPath'];
        $newNamePath = $request['newNamePath'];
        $newName = $request['newName'];
        if (strpos($itemPath, $this->sourcePath) !== false ) {
            // rename in source tree
            try {
                rename($itemPath, $newNamePath);
            } catch (Throwable $e) {
                return $this->returnError(__('messages.sync_file_tree_rename_exception'), $e->getMessage());
            }
        } else {
            // rename in destination tree
            DB::beginTransaction();
            try {
                $result = $this->fileService->renameFilesOnDbFromTree($itemPath, $newName, $this->destinationPath);
                if ($result == NORMALLY_DONE) {
                    // rename on disk
                    rename($itemPath, $newNamePath);
                } else if ($result == ERROR_INVALID_PATH) {
                    DB::rollBack();
                    return $this->returnError(__('messages.sync_file_tree_rename_invalid_path'));
                } else { // ERROR_FILE_USING
                    DB::rollBack();
                    return $this->returnError(__('messages.sync_file_tree_rename_using_file'));
                }
            } catch (Throwable $e) {
                DB::rollBack();
                return $this->returnError(__('messages.sync_file_tree_rename_exception'), $e->getMessage());
            }
            DB::commit();
        }
        return $this->returnSuccess();
    }

    public function syncFiles(Request $request) {
        $tempPath = env('TEMP_PATH');
        $filesToCopy = $request['newFiles'];
        $filesToDeleteAtDes = $request['deletedFiles'];
        $copiedFiles = array();
        $movedFiles = array();
        $step = 0;
        try {
            //========================================
            // Copy, delete files on disk
            //========================================

            // Step1. Move files which will be deleted from destination path to temp path
            $step++;
            foreach($filesToDeleteAtDes as $file) {
                $move_source = $this->destinationPath."/".$file["path"];
                $move_destination = $tempPath."/".$file["fileObj"]["customer"]."/".$file["fileObj"]["fileName"];
                $result = $this->fileService->moveFileOnDisk($move_source, $move_destination);
                if ($result) {
                    $movedFiles[] = $file;
                } else {
                    throw new Exception();
                }
            }
            // Step2. Copy files from source to destination
            $step++;
            foreach($filesToCopy as $file) {
                $copySource = $this->sourcePath."/".$file['source'];
                $copyDestination = $this->destinationPath."/".$file['destination'];
                $result = $this->fileService->copyFile($copySource, $copyDestination);
                if ($result) {
                    $copiedFiles[] = $file;
                } else {
                    throw new Exception();
                }
            }

            // Step3: Check deleted files contain playing files
            $step++;
            if (count($filesToDeleteAtDes) > 0) {
                if ($this->fileService->containPlayingFile($filesToDeleteAtDes)) {
                    throw new Exception();
                }
            }

            //========================================
            // Insert, remove files into/from database
            //========================================
            DB::beginTransaction();
            // Step4. Remove files from database
            $step++;
            if (count($filesToDeleteAtDes) > 0) {
                $this->fileService->deleteFilesOnDb($filesToDeleteAtDes);
            }

            // Step5. Insert files into database
            $step++;
            $this->fileService->insertFilesToDb($this->destinationPath, $filesToCopy);

            // Step6. After deleted and copied, delete all empty sub-folders and all hidden items
            $step++;
            $this->fileService->cleanCustomerFolder($this->destinationPath);

            // Step7. Remove all files in temp folder
            $step++;
            $this->fileService->emptyCustomerFolder($tempPath);

            // Step8. After copied, delete all files in source folder
            if (env('DELETE_SOURCE_FILE', true)) {
                $step++;
                $this->fileService->emptyCustomerFolder($this->sourcePath);
            }

        } catch (Throwable $e) {
            if ($step >= 6) {
                DB::commit();
            } else {
                if ($step >= 4) {
                    DB::rollBack();
                }
                // Delete copied files from destination folder
                foreach ($copiedFiles as $copiedFile) {
                    $this->fileService->deleteFileOnDisk($this->destinationPath."/".$copiedFile['destination']);
                }
                // Put back moved files to destination folder
                foreach ($movedFiles as $movedFile) {
                    $move_destination = $this->destinationPath . "/" . $movedFile["path"];
                    $move_source = $tempPath."/".$movedFile["fileObj"]["customer"]."/".$movedFile["fileObj"]["fileName"];
                    $this->fileService->moveFileOnDisk($move_source, $move_destination);
                }
                // Remove all empty folders and hidden items in customer folders in destination path
                $this->fileService->cleanCustomerFolder($this->destinationPath);
            }
            return $this->returnError(__('messages.sync_file_failed_step' . $step), $e->getMessage());
        }
        DB::commit();
        return $this->returnSuccess([
            "copiedFiles" => $copiedFiles,
            "deletedFiles" => $movedFiles,
        ]);
    }
}
