<?php

namespace SolrKDE;

require_once 'MailChecker.php';
require_once 'FileSystem.php';
require_once 'Mail.php';
require_once 'SolrFile.php';
require_once 'SolrService.php';

const SOLR_DATA= '/media/dimitric/d9588a19-3aa9-4873-b29f-cf4adb2eaca5/homeData/Development/kde-commits-solr/solrimport';
const MAIL_FOLDER = '/media/dimitric/d9588a19-3aa9-4873-b29f-cf4adb2eaca5/homeData/kde-commits/[Gmail].All Mail/new';

const SOLR_HOME = '/home/dimitric/solr-7.1.0';
$mailService = new MailChecker();
$mailService->setMailFolderFullPath(MAIL_FOLDER);
$mailService->refresh();

$mailFolder = $mailService->getMailFolderFullPath();

$listOfMails = FileSystem::getFileList($mailFolder);

$solrService = new SolrService();
$solrService->setSolrServer('localhost', 'kde', SOLR_HOME); 

foreach($listOfMails as $mailFileName) {
    $mail = new Mail();
    $mail->setFromFile($mailFolder,$mailFileName);
    $solrFile = new SolrFile();
    $solrFile->setFromMail($mail);
    FileSystem::saveFile($solrFile->getId().".json", SOLR_DATA, $solrFile->getJson() );
}
$solrService->updateSolr(SOLR_DATA, "*.json");

?>
