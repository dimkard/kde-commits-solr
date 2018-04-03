<?php

namespace SolrKDE;

require_once 'FileSystem.php';


class RepositoryInformation { 
    const PROJECTS_FILE = './data/projects.json';

    private $plasmaProjects;
    private $applicationProjects;
    private $frameworksProjects;

    public function loadRepositoryData() {
        $projectsArray = $this->getProjectsArray(self::PROJECTS_FILE);
        $this->plasmaProjects = $projectsArray['plasma']; 
        $this->applicationProjects = $projectsArray['applications'];
        $this->frameworksProjects = $projectsArray['frameworks'];
        
        var_dump($this->frameworksProjects);
    }

    private function getProjectsArray($fileName) {
        $projectsString = FileSystem::getFileContent($fileName);
        $projectsArray = json_decode($projectsString, true, 512);
        return $projectsArray;
    }
}
