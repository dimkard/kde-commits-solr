<?php

namespace SolrKDE;

class MailContentMiner {
    
    public static function getClientIp($sourceMail) {  
        $ClientIp = "";

        if ( preg_match_all ('/client-ip=([^;]+);/', $sourceMail->getReceived() ,$ClientIpArray) == 1) {
            $ClientIp =  $ClientIpArray[1][0];
        }
        else {
            $ClientIp = "";
        }
        return $ClientIp;
    }

    public static function getTranslationLanguage($sourceMail) {  
        $language="";
        $subject= self::getSubject ($sourceMail);
        if (self::getIstranslation($sourceMail)) {
            if ( preg_match_all ('/.*(?:l10n-kf5|l10n-kde4)\/([^\/]+)\//',$subject,$languageArray) == 1) {
                $language =  $languageArray[1][0];
            }
            if ( preg_match_all ('/.*(?:l10n-support\/)([^\/]+)\/summit/',$subject,$languageArray) == 1) {
                $language = ($languageArray[1][0] != "templates") ? $languageArray[1][0] : "";
            }
        }
        return $language;
    }
           
    public static function getId($sourceMail) {  
        return hash("md5",$sourceMail->getFileName());
    }
    
    public static function getSubject( $sourceMail) {
        return $sourceMail->getSubject();
    }
    
    public static function getProject ($sourceMail) {
        $project = "";
        $subject = $sourceMail->getSubject();
        
        if ( preg_match_all ('/^\[([^\]]+)\]/',$subject, $projectArray) == 1) {
            $project =  $projectArray[1][0];
        }
        else if ( preg_match_all ('/(.*l10n.*)/',$subject, $projectArray) == 1) {
            $project =  "translation";
        }
        else if ( preg_match_all ('/(.*www\/*)/',$subject, $projectArray) == 1) {
            $project =  "www";
        }
        else {
            $project = "No project found";
        }
        
        return $project;
    }
    
    public static function getFrom ($sourceMail) {
        return $sourceMail->getFrom();
    }
    
    public static function getCommitDate ($sourceMail)  {
        $commitDate = date_create($sourceMail->getMailDate());
        $commitdateFormatted = date_format($commitDate, 'Y-m-d\TH:i:s\Z');
        return $commitdateFormatted;
    }
    
    public static function getMessage($sourceMail){
        return $sourceMail->getContent();
    }
    
    public static function getBug($sourceMail) {
        $bug = "";

        if ( preg_match_all ('/BUG:\s*([0-9]+)/', self::getMessage($sourceMail) ,$bugArray) == 1) {
            $bug =  $bugArray[1][0];
        }
        else {
            $bug = "";
        }
        return $bug;
    }
    
    public static function getFixesBug($sourceMail) {
        return (self::getBug($sourceMail) != "") ? true : false;
    } 
    public static function getRevision($sourceMail) {
        $revision = "";
        if ( preg_match_all ('/Differential Revision:\s*(.+)\s/', self::getMessage($sourceMail),$revisionArray) == 1) {
            $revision =  $revisionArray[1][0];
        }
        else {
            $revision = "";
        }
        return $revision;
    }
    public static function getIsRevision($sourceMail) {
        return (self::getRevision($sourceMail) != "") ? true : false;
        
    }
    public static function getIstranslation($sourceMail) {
        return (self::getProject($sourceMail) == "translation") ? true : false;
    }
}
?>
