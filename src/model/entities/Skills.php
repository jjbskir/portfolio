<?php

namespace model\entities;

/**
 * Description of Skills
 *
 * @author Jeremy Bohrer 
 */
class Skills {
    
    private $skills;
    
    /**
     * constructor
     * 
     * retrieves info from databases and creates project objects.
     */
    public function __construct($dbSkills) {
        if (isset($dbSkills)) foreach ($dbSkills as $skill) {
            if (isset($skill)) {
                $skillObject = new Skill($skill);
                $this->skills[$skill['id']] = $skillObject;
            }
        }
    }
    
    /*
     * prepares a form related to projects for deleting.
     * Create a map relating name to id.
     */
    public function getSkillIdMap() {
        $idNameMap = array();
        if (is_array($this->skills)) foreach ($this->skills as $skillObject) {
            $idNameMap[$skillObject->getId()] = $skillObject->getSkill();
        }
        return $idNameMap;
    }
    
    public function getSkills() {
        return $this->skills;
    }
    
}

class Skill {
    
    private $id;
    private $skill;
    private $typeId;
    
    public function __construct($_skill) {
        $this->id = $_skill['id'];
        $this->skill = $_skill['skill'];
        $this->typeId = $_skill['typeId'];
    }
    
    public function getId() {
        return $this->id;
    }
            
    public function getSkill() {
        return $this->skill;
    }
    
    public function getTypeId() {
        return $this->typeId;
    }
    
}

?>
