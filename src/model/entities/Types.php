<?php

namespace model\entities;

/*
 * orginization of type classes.
 */
class Types {
    
    /* maps type => type object */
    private $types;
    /* maps id => type */
    private $mapIdType;
    /* maps type => type */
    private $typesKey;
    
    public function __construct($dbTypes) {
        if (isset($dbTypes)) foreach ($dbTypes as $type) {
            $typeObject = new Type($type); 
            $this->types[$type['type']] = $typeObject;
        }
    }
    
    /**
     * @param type $typeName, name of type to match to.
     * @return type, type object. 
     */
    public function getType($typeName) {
        assert('is_string($typeName)');
        $types = $this->getTypes();
        return $types[$typeName];
    }
    
    /**
     * @return type, mapping of id => type. 
     */
    public function getMapIdType() {
        if (is_array($this->types)) foreach ($this->types as $typeObject) {
            $this->mapIdType[$typeObject->getId()] = $typeObject->getType();
        }
        return $this->mapIdType;
    }
    
    /**
     * @return type, array of type id.
     */
    public function getTypesKey() {
        $this->typesKey = array();
        if (is_array($this->types)) foreach ($this->types as $typeObject) {
            array_push($this->typesKey, $typeObject->getId());
        }
        return $this->typesKey;
    }

    public function getTypes() {
        return $this->types;
    }
    
}


/*
 * type of projects that can be created.
 */
class Type {
    
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
