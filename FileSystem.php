<?php

namespace SolrKDE;

class FileSystem {
	public static function copyToFolder($srcFolder, $dstFolder) {
		$success = false;
		if ($srcFolderResource = openFolder ( $srcFolder )) {
			while ( ($fileName = readdir ( $srcFolderResource )) !== false ) {
				if ($fileName != '.' && $fileName != '..') {
					copy ( $newmaildir . "/" . $file_name, $dstFolder . '/'.$fileName);
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
// 	public function getFileContent($file) {
// 		return $fileContent;
// 	}
}

?>
