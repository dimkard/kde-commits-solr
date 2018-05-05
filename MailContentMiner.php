<?php

namespace SolrKDE;

require_once 'RepositoryInformation.php';

class MailContentMiner {
    
    public static function getProjectType ($sourceMail) {
        $project = self::getProject($sourceMail);
        $repoInfo = new RepositoryInformation();
        $repoInfo->loadRepositoryData();
        $plasma = $repoInfo->getPlasmaProjects();
        $apps = $repoInfo->getApplicationProjects();
        $frameworks = $repoInfo->getFrameworksProjects();
        
        if( array_search($project, $plasma) ) {
            return "Plasma";
        }
        else if( $project == "translation" ) {
            return "Translation";
        }
        else if( $project == "www" ) {
            return "www";
        }
        else if( array_search($project, $apps) ) {
            return "Applications";
        }
        else if( array_search($project, $frameworks) ) {
            return "Frameworks";
        }
        else {
            return "Other";
        }
        
        return "Other";
    }
    
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
        $languageCode="";
        $language="";
        $subject= self::getSubject ($sourceMail);
        $repoInfo = new RepositoryInformation();
        $repoInfo->loadRepositoryData();
        $languages = $repoInfo->getLanguages();
        if (self::getIstranslation($sourceMail)) {
            if ( preg_match_all ('/.*(?:l10n-kf5|l10n-kde4)\/([^\/]+)\//',$subject,$languageArray) == 1) {
                $languageCode =  $languageArray[1][0];
            }
            if ( preg_match_all ('/.*(?:l10n-support\/)([^\/]+)\/summit/',$subject,$languageArray) == 1) {
                $languageCode = ($languageArray[1][0] != "templates") ? $languageArray[1][0] : "";
            }
        }
        

        if( array_key_exists($languageCode,$languages) ) {
        
            $language = $languages[$languageCode];
        }
        else {
            $language = "";
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
        
        if ( preg_match_all ('/^\[([^\]\/]+)(?:\]|\/)/',$subject, $projectArray) == 1) {
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
        $behalfOf=self::getBehalfOf($sourceMail);
        if(!empty($behalfOf)) {
            return $behalfOf;
        }      
        return rtrim(str_replace( "<null@kde.org>" , "", iconv_mime_decode($sourceMail->getFrom(),0,"UTF-8")));
    }
    
    public static function getAuthorInitials ($sourceMail) {
        $from = trim(self::getFrom($sourceMail));
        if($from != "l10n daemon script") {
            $initialsArray = preg_split("/\s+/", $from);
            $initials = "";
            foreach ( $initialsArray as $word) {
                $initial = trim(substr($word, 0, 1));
                if(!empty($initial)) {
                    $initials = empty($initials) ? $initial."." : $initials." ".$initial .".";
                }
            }
            return $initials;
        }
        else {
            return $from;
        }
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

    public static function getBehalfOf($sourceMail) {
        if ( preg_match_all ('/[bB]ehalf\s*[oO]f\s*(.+)/', self::getMessage($sourceMail),$behalfOfArray) == 1) {
            $urlBehalfOf = str_replace( "=" , "%", $behalfOfArray[1][0]);
            return rtrim(urldecode($urlBehalfOf),'.');
        }
        return "";
    }    
}
?>
