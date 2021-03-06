<?php

namespace SolrKDE;

require_once 'MailChecker.php';
require_once 'FileSystem.php';
require_once 'Mail.php';
require_once 'SolrFile.php';
require_once 'SolrService.php';

const SOLR_DATA= '/home/dimitric/kde-commits-solr/solrimport';
const MAIL_FOLDER = '/home/dimitric/kde-commits/[Gmail].All Mail/new';
const SOLR_HOME = '/home/dimitric/solr-7.3.0';
const LOG_ARCHIVE=  '/home/dimitric/kde-commits-solr/logarchive';

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
if( FileSystem::copyToFolder(SOLR_DATA, LOG_ARCHIVE) ) {
    FileSystem::clearFolder(SOLR_DATA);
}
?>
