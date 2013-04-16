<?php

namespace model\entities;

/**
 * Projects info.
 */
class Projects {
    
    /**
     * name => project object.
     */
    private $projects = array();
    
    /*
     * name => name
     * used for forms.
     */
    private $nameNameMap = array();
    
    /**
     * type => project object. 
     * used for the portfolio page which is divided by project types.
     */
    private $typeProjectMap = array();
    
    /**
     * constructor
     * 
     * retrieves info from databases and creates project objects.
     */
    public function __construct($dbArray) {
        if (isset($dbArray)) foreach ($dbArray as $project) {
            if (isset($project)) {
                
                $projectObject = new Project($project);
                $this->projects[$project['name']] = $projectObject;
                  
                if (!isset($this->typeProjectMap[$project['type']])) {
                    $this->typeProjectMap[$project['type']] = array();
                    array_push($this->typeProjectMap[$project['type']], $projectObject);
                }
                else {
                    array_push($this->typeProjectMap[$project['type']], $projectObject);
                }
           
            }
        }
    }
    
    /**
     * @param type $projectName, takes a project name
     * @return type, returns the project object.
     */
    public function getProject($projectName) {
        assert('is_string($projectName)');
        $projects = $this->getProjects();
        return $projects[$projectName];
    }
    
    /**
     * @param type $projectName, to check if it exists.
     * @return boolean, if the project does exists return true,
     *                  else return false.
     */
    public function projectExists($projectName) {
        assert('is_string($projectName)');
        $projects = $this->getProjects();
        if (isset($projects[$projectName])) {
            return TRUE;
        }
        return FALSE;
    }
    
    /*
     * prepares a form related to projects for upadating.
     */
    public function getNameNameMap() {
        $projectsName = array_keys($this->projects);
        foreach ($projectsName as $name) {
            $this->nameNameMap[$name] = $name;
        }
        return $this->nameNameMap;
    }
    
    /**
     * getters 
     */
    public function getProjects() {
        return $this->projects;
    }
    
    public function getTopProjects($int) {
        return array_slice($this->projects, 0, $int);  
    }
    
    public function getProjectsByType() {
        return $this->typeProjectMap;
    }

}



/**
 * Info on each individual project.
 * Gets stored in an array in class Projects with the associative name
 * of the project as the array's index.
 */
class Project {
    
    /* private variables  */
    private $id;
    private $dateCreated;
    private $dateCreatedView;
    private $name;
    private $description;
    private $imageLocation;
    private $externalLocation;
    private $type;
    private $projectArray;
    
    /**
     * constructor
     * 
     * takes info from each project array in the database and creates objects.
     */
    public function __construct($_project) {
        if (isset($_project)) {
            $this->id               = $_project['id'];
            $this->dateCreated      = $_project['dateCreated'];
            $this->name             = $_project['name'];
            $this->description      = $_project['description'];
            $this->imageLocation    = $_project['imageLocation'];
            $this->externalLocation = $_project['externalLocation'];
            $this->type             = $_project['type'];
            $this->dateCreatedView  = $this->setDateCreatedView($this->dateCreated);
            $this->projectArray     = $_project;
        }
    }
    
    /**
     * stores a project in a database.
     */
    public function storeProject($dbPortfolio) {
        $dbPortfolio->storeProject($this->projectArray);
    }
    
    public function setDateCreatedView($date) {
        assert('is_string($date)');
        if (isset($date)) {
            $dateArray = explode(' ', $date);
            assert('count($dateArray) == 2');
            $dateArray[0] = str_replace('-',  '/', $dateArray[0]);
            $dateArrayFinal = explode('/', $dateArray[0]);
            assert('count($dateArrayFinal) == 3');
            $year = $dateArrayFinal[0];
            $month = $dateArrayFinal[1];
            $day = $dateArrayFinal[2];
            return $month . '/' . $day . '/' . $year;
        }
    }
    
    /**
     * getters
     */
    public function getId() {
        return $this->id;
    }
    
    public function getDateCreated() {
        return $this->dateCreated;
    }
    
    public function getDateCreatedView() {
        return $this->dateCreatedView;
    }

    public function getName() {
        return $this->name;
    }
    
    public function getDescription() {
        return $this->description;
    }
    
    public function getImageLocation() {
        return $this->imageLocation;
    }
    
    public function getExternalLocation() {
        return $this->externalLocation;
    }
    
    public function getType() {
        return $this->type;
    }
    
}


?>
