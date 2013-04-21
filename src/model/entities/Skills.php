<?php

namespace model\entities;

/**
 * Description of Skills
 *
 * @author Jeremy Bohrer 
 */
class Skills {
    
    private $skills;
    private $skillTypes;
    private $typeSkillMap;


    /**
     * constructor
     * 
     * retrieves info from databases and creates project objects.
     */
    public function __construct($dbSkills, $_skillTypes) {
        $this->skillTypes = $_skillTypes;
        if (isset($dbSkills)) foreach ($dbSkills as $skill) {
            if (isset($skill)) {
                $skillObject = new Skill($skill);
                $this->skills[$skillObject->getId()] = $skillObject;
                $skillTypeObject = $this->skillTypes->getSkillType($skillObject->getTypeId());
                
                if (!isset($this->typeSkillMap[$skillTypeObject->getSkillType()])) {
                    $this->typeSkillMap[$skillTypeObject->getSkillType()] = array();
                    array_push($this->typeSkillMap[$skillTypeObject->getSkillType()], $skillObject);
                }
                else {
                    array_push($this->typeSkillMap[$skillTypeObject->getSkillType()], $skillObject);
                }
              
            }
        }
    }
    
    /*
     * prepares a form related to projects for deleting.
     * Create a map relating name to id.
     */
    public function getIdSkillMap() {
        $idSkillMap = array();
        if (is_array($this->skills)) foreach ($this->skills as $skillObject) {
            $idSkillMap[$skillObject->getId()] = $skillObject->getSkill();
        }
        return $idSkillMap;
    }
    
    public function getTypeSkillMap() {
        return $this->typeSkillMap;
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
