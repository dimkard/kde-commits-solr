<?php

namespace SolrKDE;

require_once 'MailContentMiner.php';
class SolrFile {
    private $id;
    private $subject;
    private $project;
    private $from;
    private $commitDate; 
    private $message;
    private $bug;
    private $fixesBug;
    private $revision;
    private $isRevision;
    private $isTranslation;
    private $translationLanguage;

    
    public function setFromMail($sourceMail) {
		$this->setId($sourceMail) ;
		$this->setSubject($sourceMail) ;
		$this->setProject($sourceMail) ;
		$this->setFrom($sourceMail) ;
		$this->setCommitdate($sourceMail) ;
		$this->setMessage($sourceMail) ;
		$this->setBug($sourceMail) ;
		$this->setFixesBug($sourceMail) ;
		$this->setRevision($sourceMail) ;
		$this->setIsrevision($sourceMail)  ;
		$this->setIstranslation($sourceMail) ;
		$this->setTranslationLanguage($sourceMail) ;
    }

    public function getJson() {

    	$commitArray = array (
    			"id" => $this->id,
    			"subject" => $this->subject,
    			"project" => $this->project,
    			"from" => $this->from,
    			"date" =>$this->commitDate,
    			"message" => $this->message,
    			"bug" => $this->bug,
    			"fixesbug" => $this->fixesBug,
    			"revision" => $this->revision,
    			"isrevision" => $this->isRevision,
    			"istranslation" => $this->isTranslation,
    			"translationlanguage" =>  $this->translationLanguage,
    			);

    	return \json_encode($commitArray, JSON_PRETTY_PRINT,512);
    }
    public function getId() {
    	return $this->id;
    }    
    
    private function setId($sourceMail) {
    	$this->id = MailContentMiner::getId( $sourceMail );
    }
    
    private function setTranslationLanguage($sourceMail) {
    	$this->translationLanguage = MailContentMiner::getTranslationLanguage( $sourceMail );
    }
    
    private function setSubject($sourceMail) {
    	$this->subject = MailContentMiner::getSubject( $sourceMail);
    }
    
    private function setProject($sourceMail) {
    	$this->project = MailContentMiner::getProject ($sourceMail);
    }
    
    private function setFrom($sourceMail) {
    	$this->from = MailContentMiner::getFrom ($sourceMail);
    }
    
    private function setCommitdate($sourceMail) {
    	$this->commitDate = MailContentMiner::getCommitDate ($sourceMail);
    }
    
    private function setMessage($sourceMail) {
    	$this->message = MailContentMiner::getMessage($sourceMail);
    }
    
    private function setBug($sourceMail) {
    	$this->bug = MailContentMiner::getBug($sourceMail);
    }
    
    private function setFixesBug($sourceMail) {
    	$this->fixesBug = MailContentMiner::getFixesBug($sourceMail);
    }
    
    private function setRevision($sourceMail) {
    	$this->revision = MailContentMiner::getRevision($sourceMail);
    }
    
    private function setIsrevision($sourceMail)  {
    	$this->isRevision= MailContentMiner::getIsRevision($sourceMail);
    }
    
    private function setIstranslation($sourceMail) {
    	$this->isTranslation = MailContentMiner::getIstranslation($sourceMail);
    }
    
}
?>
