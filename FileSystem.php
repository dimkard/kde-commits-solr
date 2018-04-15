<?php

namespace SolrKDE;

class FileSystem {
    public static function copyToFolder($srcFolder, $dstFolder) {
        $success = false;
        if ($srcFolderResource = self::openFolder ( $srcFolder )) {
            while ( ($fileName = readdir ( $srcFolderResource )) !== false ) {
                if ($fileName != '.' && $fileName != '..') {
                    copy ( $srcFolder . "/" . $fileName, $dstFolder . '/'.$fileName);
                }
            }
            closedir ( $srcFolderResource );
            $success = true;
        }
        
        return $success;
    }
    private function openFolder($srcFolder) {
        if (is_dir ( $srcFolder )) {
            if ($srcFolderResource = opendir ( $srcFolder )) {
                return $srcFolderResource;
            }
        }
        return null;
    }
    
    public static function clearFolder($folder) {
        $folderIterator = new \RecursiveDirectoryIterator($folder, \FilesystemIterator::SKIP_DOTS);
        $recursiveFolderIterator  = new \RecursiveIteratorIterator($folderIterator, \RecursiveIteratorIterator::CHILD_FIRST);
        foreach ( $recursiveFolderIterator as $file ) {
            $file->isDir() ?  rmdir($file) : unlink($file);
        }
        return true;
    }
    
    public static function getFileList($folder) {
        $fileNameList = array ();
        if ($folderResource = self::openFolder ( $folder )) {
            while ( ($fileName = readdir ( $folderResource )) !== false ) {
                if ($fileName != '.' && $fileName != '..') {
                    $fileNameList [] = $fileName;
                }
            }
        }
        return $fileNameList;
    }
    public static function saveFile($targetName, $targetFolder, $content) {
        if (is_dir ( $targetFolder )) {
            file_put_contents($targetFolder.'/'.$targetName,$content);
        }
    }
    public static function getFileContent($filePath) {
        $fileContent = file_get_contents($filePath);
        return $fileContent;
    }
    
}

?>
