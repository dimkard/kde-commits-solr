<?php

namespace SolrKDE;

require_once 'FileSystem.php';


class RepositoryInformation { 
    const PROJECTS_FILE = './data/projects.json';
    const LANGUAGES_FILE = './data/languages.json';

    private $plasmaProjects;
    private $applicationProjects;
    private $frameworksProjects;
    private $languages;

    public function getPlasmaProjects() {
        return $this->plasmaProjects; 
    }
    
    public function getApplicationProjects() {
        return $this->applicationProjects;
    }
    
    public function getFrameworksProjects() {
        return $this->frameworksProjects;
    }

    public function getLanguages() {
        return $this->languages; 
    }
    
    public function loadRepositoryData() {
        $projectsArray = $this->getProjectsArray(self::PROJECTS_FILE);
        $this->plasmaProjects = $projectsArray['plasma']; 
        $this->applicationProjects = $projectsArray['applications'];
        $this->frameworksProjects = $projectsArray['frameworks'];
        $this->languages = $this->getLanguagesArray(self::LANGUAGES_FILE);
    }

    private function getProjectsArray($fileName) {
        $projectsString = FileSystem::getFileContent($fileName);
        $projectsArray = json_decode($projectsString, true, 512);
        return $projectsArray;
    }
    
    private function getLanguagesArray($fileName) {
        $languagesString = FileSystem::getFileContent($fileName);
        $languagesArray = json_decode($languagesString, true, 512);
        return $languagesArray;
    }
}
