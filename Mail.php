<?php

namespace SolrKDE;

require_once './phemail/vendor/autoload.php';

class Mail {
    private $fileName;
    private $received;
    private $from;
    private $subject;
    private $content;
    private $mailDate;
    private $receivedSpf;
    
    function setFromFile($direcrtoryName, $fileName) {
    	$parser = new \Phemail\MessageParser();
    	$this->fileName = $fileName;
    	$this->mailMessage = $parser->parse($direcrtoryName . '/' . $fileName);
    	$this->subject = $this->mailMessage->getHeaderValue('subject');
    	$this->content =  $this->mailMessage->getContents();
    	$this->mailDate =  $this->mailMessage->getHeaderValue('date');
    	$this->from =  $this->mailMessage->getHeaderValue('from');
    	$this->received =  $this->mailMessage->getHeaderValue('received-spf');
    }
    
//     function getJson($file) {        
//         //..construct json response from properties
//         return jsonMail;
//     }
    
    public function getFileName() {
        return $this->fileName;
    }

    public function getReceived() {
    	return $this->received;
    }

    public function getFrom() {
    	return $this->from;
    }

    public function getSubject() {
    	return $this->subject;
    }

    public function getContent() {
    	return $this->content;
    }
    
    public function getMailDate() {
    	return $this->mailDate;
    }
    
}

?>
