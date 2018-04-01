<?php

namespace SolrKDE;

class MailChecker {
	private $mailFolderFullPath;
    
    public function refresh() {
    	echo exec('offlineimap').PHP_EOL;
    	return true;
    }
    
    public function setMailFolderFullPath($folderNamePath) {
    	$this->mailFolderFullPath = $folderNamePath;
    }
    
    public function getMailFolderFullPath() {
    	return $this->mailFolderFullPath;
    }
}

?>
