<?php

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
    public function getStuff() {
        $idTypeMap = array();
        if (is_array($this->skillTypes)) foreach ($this->skillTypes as $skillTypeObject) {
            $idTypeMap[$skillTypeObject->getId()] = $skillTypeObject->getType();
        }
        return $idTypeMap;
    }
    
    public function getSkillTypesKey() {
        $keys = array();
        if (is_array($this->skillTypes)) foreach ($this->skillTypes as $skillTypeObject) {
            array_push($keys, $typeObject->getId());
        }
        return $keys;
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
    private $type;
    
    public function __construct($_type) {
        $this->id   = $_type['id'];
        $this->type = $_type['type'];
    }
    
    public function getId() {
        return $this->id;
    }

    public function getType() {
        return $this->type;
    }
           
}


?>
