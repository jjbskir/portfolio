<?php

namespace model;

/**
 * Description of EntitiesData
 *
 * @author Jeremy Bohrer 
 */
class EntitiesData {
    
   /*
     * @var Connection
     */
    private $db;
    
    /**
     * Constructor
     * 
     * @param $db \Doctrine\DBAL\Connection
     */
    public function __construct($db) {
        $this->db = $db;
    }
   
    
    /** select all info to create model\entitie classes. **/
    
    
    /**
     * get all of the admins info.
     */
    public function getAdmin() {
        $sql = "SELECT * FROM users";
        $admin = $this->db->fetchAssoc($sql);
        return $admin;
    }
    
    /**
     * get all of the projects info.
     */
    public function getProjects() {
        $sql = "SELECT Projects.*, types.type FROM Projects
                JOIN types 
                ON Projects.typeId = types.id
                ORDER BY dateCreated DESC";
        $projects = $this->db->fetchAll($sql);
        return $projects;
    }   
    
    /**
     * get all of the project types.
     */
    public function getTypes() {
        $sql = "SELECT * FROM types";
        $types = $this->db->fetchAll($sql);
        return $types;
    }
    
    public function getSkillTypes() {
        $sql = "SELECT * FROM skillTypes";
        $skillTypes = $this->db->fetchAll($sql);
        return $skillTypes;
    }
    
    public function getSkills() {
        $sql = "SELECT * FROM skills";
        $skills = $this->db->fetchAll($sql);
        return $skills;
    }
    
    /**
     * get the captions for images.
     */
    public function getCaptions() {
        $sql = "SELECT * FROM Images";
        $captions = $this->db->fetchAll($sql);
        return $captions;
    }
    
}

?>
