<?php
namespace SolrKDE;

class SolrService {
    private $solrHost;
    private $solrHome;
    private $solrCollection;
    
    public function setSolrServer($host, $collection, $home) {
    	$this->solrHost = $host;
    	$this->solrCollection = $collection;
    	$this->solrHome = $home;
    }
    public function updateSolr($solrJsonFolder, $solrJsonFile) {
        $command = $this->solrHome.'/bin/post -c '.$this->solrCollection.' '.$solrJsonFolder.'/'.$solrJsonFile;
        echo $command.PHP_EOL;
    	exec($command); 
    	return true;
    }
}

?>
