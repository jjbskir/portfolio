<?php

namespace model\entities;

/**
 * Description of SkillTypes
 *
 * @author Jeremy Bohrer 
 */
class SkillTypes {
    
    private $skillTypes;
    
    public function __construct($dbSkillTypes) {
        if (isset($dbSkillTypes)) foreach ($dbSkillTypes as $skillType) {
            $skillTypeObject = new SkillType($skillType); 
            $this->skillTypes[$skillType['id']] = $skillTypeObject;
        }
    }
    
    /**
     * @return type, mapping of id => type. 
     */
    public function getIdTypeMap() {
        $idTypeMap = array();
        if (is_array($this->skillTypes)) foreach ($this->skillTypes as $skillTypeObject) {
            $idTypeMap[$skillTypeObject->getId()] = $skillTypeObject->getSkillType();
        }
        return $idTypeMap;
    }
    
    public function getSkillTypesKey() {
        $keys = array();
        if (is_array($this->skillTypes)) foreach ($this->skillTypes as $skillTypeObject) {
            array_push($keys, $skillTypeObject->getId());
        }
        return $keys;
    } 
       
    public function getSkillType($_id) {
        $types = $this->getSkillTypes();
        if (isset($types[$_id])) {
            return $types[$_id];
        }
        return null;
    }
    
    public function getSkillTypes() {
        return $this->skillTypes;
    }
    
}

/*
 * type of skills to add.
 */
class SkillType {
    
    private $id;
    private $skillType;
    
    public function __construct($_type) {
        $this->id   = $_type['id'];
        $this->skillType = $_type['skillType'];
    }
    
    public function getId() {
        return $this->id;
    }

    public function getSkillType() {
        return $this->skillType;
    }
           
}


?>
