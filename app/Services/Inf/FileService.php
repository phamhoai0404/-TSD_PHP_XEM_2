<?php

namespace App\Services\Inf;

use App\Entities\File;
use App\Entities\PlayList;
use Illuminate\Support\Carbon;

class FileService
{
    //=============================================
    // Databases
    //=============================================
    public function insertFilesToDb($destinationPath, $filesToCopy) {
        $newFiles = array();
        foreach ($filesToCopy as $file) {
            $fileInfo = new PDFInfoService($destinationPath."/".$file['destination']);
            $fileObj = $file["fileObj"];
            $fileObj["pageNum"] = $fileInfo->pages;
            $fileObj["size"] = $fileInfo->fileSize;
            $fileObj["created_at"] = Carbon::now()->format("Y-m-d H:i:s");
            $fileObj["updated_at"] = Carbon::now()->format("Y-m-d H:i:s");
            $newFiles[] = $fileObj;
        }
        File::insert($newFiles);
    }

    public function containPlayingFile($filesToDeleteAtDes) {
        $usingFileIds = $this->getAllPlayingFileIds();

        $query = File::select("id");
        $query = $this->deletedFileQueryBuilder($query, $filesToDeleteAtDes);
        $deletedFileIds = array_map(function($res) {
            return $res["id"];
        }, $query->get()->toArray());

        $cannotDeleteFileIds = array_intersect($usingFileIds, $deletedFileIds);
        return count($cannotDeleteFileIds) > 0;
    }

    public function deleteFilesOnDb($filesToDeleteAtDes) {
        $query = File::query();
        $query = $this->deletedFileQueryBuilder($query, $filesToDeleteAtDes);
        $query->delete();
    }

    public function deleteFilesOnDbFromTree($itemPath, $prefix) {
        $usingFileIds = $this->getAllPlayingFileIds();
        $query = File::select('id');
        $result = $this->changeFileOnDbFromTreeQueryBuilder($query, $itemPath, $prefix);
        if ($result["query"] != null) {
            $deletedIds = $result["query"]->get()->pluck('id')->all();
            $cannotDeleteFileIds = array_intersect($usingFileIds, $deletedIds);
            if (count($cannotDeleteFileIds) > 0) {
                return ERROR_FILE_USING;
            } else {
                $result["query"]->delete();
                return NORMALLY_DONE;
            }
        } else {
            return ERROR_INVALID_PATH;
        }
    }

    public function renameFilesOnDbFromTree($itemPath, $newName, $prefix) {
        $usingFileIds = $this->getAllPlayingFileIds();
        $query = File::select('id');
        $result = $this->changeFileOnDbFromTreeQueryBuilder($query, $itemPath, $prefix);
        if ($result["query"] != null) {
            $renameIds = $result["query"]->get()->pluck('id')->all();
            $cannotRenameFileIds = array_intersect($usingFileIds, $renameIds);
            if (count($cannotRenameFileIds) > 0) {
                return ERROR_FILE_USING;
            } else {
                $result["query"]->update([$result["level"] => $newName]);
                return NORMALLY_DONE;
            }
        } else {
            return ERROR_INVALID_PATH;
        }
    }

    //=============================================
    // File on disks
    //=============================================
    public function getDirContents($path) {
        $results = array();
        $nodes = glob($path."/".'*');
        foreach($nodes as $node) {
            $nodeName = basename($node);
            if(is_dir($node)) {
                $nodeObj = array(
                    "name" => $nodeName,
                    "id" => $node,
                    "type" => "folder",
                    "children" => $this->getDirContents($node)
                );
            } else {
                $nodeObj = array(
                    "name" => $nodeName,
                    "id" => $node,
                    "type" => "file",
                    "children" => array()
                );
            }
            $results[] = $nodeObj;
        }
        return $results;
    }

    public function copyFile($source, $destination) {
        $result = true;
        $path = pathinfo($destination);
        if (!file_exists($path['dirname'])) {
            $result = mkdir($path['dirname'], 0777, true);
        }
        if ($result) {
            $result = copy($source, $destination);
        }
        return $result;
    }

    public function deleteFileOnDisk($file) {
        return unlink($file);
    }

    public function moveFileOnDisk($source, $destination) {
        $result = true;
        $path = pathinfo($destination);
        if (!file_exists($path['dirname'])) {
            $result = mkdir($path['dirname'], 0777, true);
        }
        if ($result) {
            $result = rename($source, $destination);
        }
        return $result;
    }

    public function cleanCustomerFolder($rootPath) {
        $customerFolderPaths = $this->getChildFolderPaths($rootPath);
        foreach ($customerFolderPaths as $customerFolderPath) {
            $this->removeAllHiddenFilesAndFolders($customerFolderPath);
            $this->removeAllEmptySubfolders($customerFolderPath);
        }
    }

    public function emptyCustomerFolder($rootPath) {
        $customerFolderPaths = $this->getChildFolderPaths($rootPath);
        foreach ($customerFolderPaths as $customerFolderPath) {
            $this->clearContentOfFolder($customerFolderPath);
        }
    }

    public function removeAllHiddenFilesAndFolders($path) {
        $nodes = array_diff(scandir($path), array(".", ".."));
        foreach($nodes as $node) {
            $nodePath = $path."/".$node;
            if(preg_match('/^\.([^.]|\.[^.]|\.\.).*/', $node) == 1) {
                is_dir($nodePath) ? $this->clearContentOfFolder($nodePath, false) : unlink($nodePath);
            } else {
                if (is_dir($nodePath)) {
                    $this->removeAllHiddenFilesAndFolders($nodePath);
                }
            }
        }
    }

    public function clearContentOfFolder($path, $isRoot = true) {
        $nodes = array_diff(scandir($path), array(".", ".."));
        foreach ($nodes as $node) {
            $nodePath = $path."/".$node;
            is_dir($nodePath) ? $this->clearContentOfFolder($nodePath, false) : unlink($nodePath);
        }
        if (!$isRoot) {
            rmdir($path);
        }
    }

    //=============================================
    // Private functions
    //=============================================

    private function getChildFolderPaths($path) {
        $results = array();
        $nodes = glob($path."/".'*');
        foreach($nodes as $node) {
            if(is_dir($node)) {
                $results[] = $node;
            }
        }
        return $results;
    }

    private function removeAllEmptySubfolders($path, $isRoot = true) {
        $empty = true;
        $nodes = glob($path."/".'*');
        foreach($nodes as $node) {
            if (is_dir($node)) {
                if (!$this->removeAllEmptySubfolders($node, false)) {
                    $empty = false;
                }
            } else {
                $empty = false;
            }
        }
        if ($empty && (!$isRoot)) {
            $empty = rmdir($path);
        }
        return $empty;
    }

    private function getAllPlayingFileIds() {
        $settings = PlayList::select('setting')->get()->toArray();
        $fileIds = array();
        foreach($settings as $setting) {
            $parsedSetting = json_decode($setting["setting"]);
            foreach ($parsedSetting as $fileSetting) {
                $fileIds[] = $fileSetting->id;
            }
        }
        return array_unique($fileIds);
    }

    private function deletedFileQueryBuilder($query, $filesToDeleteAtDes) {
        $parsedData = array();
        foreach ($filesToDeleteAtDes as $file) {
            $_customer = $file["fileObj"]["customer"];
            $_fileName = $file["fileObj"]["fileName"];
            if (!isset($parsedData[$_customer])) {
                $parsedData[$_customer] = array();
            }
            $parsedData[$_customer][] = $_fileName;
        }
        $isFirst = true;
        foreach ($parsedData as $customerName => $fileNames) {
            if ($isFirst) {
                $query->where(function ($q) use ($customerName, $fileNames) {
                    $q->where('customer', $customerName)
                        ->whereIn('fileName', $fileNames);
                });
            } else {
                $query->orWhere(function ($q) use ($customerName, $fileNames) {
                    $q->where('customer', $customerName)
                        ->whereIn('fileName', $fileNames);
                });
            }
            $isFirst = false;
        }
        return $query;
    }

    private function changeFileOnDbFromTreeQueryBuilder($query ,$itemPath, $prefix) {
        $relativePath = substr($itemPath, strlen($prefix) + 1);
        $dirParts = explode('/', $relativePath);
        $customer = null; $model = null; $version = null; $depCode = null; $fileName = null;
        $level = null;
        if (count($dirParts) <= 5) {
            if (count($dirParts) > 0) {
                $customer = $dirParts[0];
                $query->where('customer', $customer);
                $level = 'customer';
            }
            if (count($dirParts) > 1) {
                $model = $dirParts[1];
                $query->where('model', $model);
                $level = 'model';
            }
            if (count($dirParts) > 2) {
                $version = $dirParts[2];
                $query->where('version', $version);
                $level = 'version';
            }
            if (count($dirParts) > 3) {
                $depCode = $dirParts[3];
                $query->where('depCode', $depCode);
                $level = 'depCode';
            }
            if (count($dirParts) > 4) {
                $fileName = $dirParts[4];
                $query->where('fileName', $fileName);
                $level = 'fileName';
            }
        } else {
            $query = null;
        }
        return array(
            "query" => $query,
            "level" => $level
        );
    }
}
