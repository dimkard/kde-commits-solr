<?php

namespace SolrKDE;

require_once 'FileSystem.php';


class RepositoryInformation { 
    const PROJECTS_FILE = './data/projects.json';

    private $plasmaProjects;
    private $applicationProjects;
    private $frameworksProjects;

    public function getPlasmaProjects() {
        return $this->plasmaProjects; 
    }
    
    public function getApplicationProjects() {
        return $this->applicationProjects;
    }
    
    public function getFrameworksProjects() {
        return $this->frameworksProjects;
    }
    
    public function loadRepositoryData() {
        $projectsArray = $this->getProjectsArray(self::PROJECTS_FILE);
        $this->plasmaProjects = $projectsArray['plasma']; 
        $this->applicationProjects = $projectsArray['applications'];
        $this->frameworksProjects = $projectsArray['frameworks'];
        
    }

    private function getProjectsArray($fileName) {
        $projectsString = FileSystem::getFileContent($fileName);
        $projectsArray = json_decode($projectsString, true, 512);
        return $projectsArray;
    }
}
