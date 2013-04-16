<?php

namespace model;

/*
 * portfolio database.
 */
class dbPortfolio {
  
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
   
    
    /** select all info to create model classes. **/
    
    
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
    
    /**
     * get the captions for images.
     */
    public function getCaptions() {
        $sql = "SELECT * FROM Images";
        $captions = $this->db->fetchAll($sql);
        return $captions;
    }
    
    
    /** over-arching project creating and deleting **/
    
    
    /**
     * @param type $arrayValues, takes an array of values about a project, 
     * and inserts them into the database.
     */
    public function storeProject($arrayValues) {
        $date = new \DateTime("now");
        $data = $this->db->insert('Projects', array('id' => $arrayValues['id'], 'dateCreated' => $date->format('Y-m-d H:i:s'),
            'name' => $arrayValues['name'], 'description' => $arrayValues['description'], 
            'imageLocation' => $arrayValues['imageLocation'], 'externalLocation' => $arrayValues['externalLocation'], 
            'typeId' => $arrayValues['type']
         ));
        if (!$data) {
            throw new \Exception('Could not store project in database.');
        }
    }

    /**
     * delete project
     */
    public function deleteProject($id) {
        $data = $this->db->delete('Projects', array('id' => $id));
        if (!$data) {
            throw new \Exception('Could not delete image in database.');
        }   
    }
    
    /**
     * @param type $arrayValues, array of values associated with type to
     * save it in the database.
     */
    public function storeType($arrayValues) {
        $data = $this->db->insert('types', array('id' => $arrayValues['id'], 
            'type' => $arrayValues['type'] ));
        if (!$data) {
            throw new \Exception('Could not store type in database.');
        }
    }
    
    /**
     * stores caption for image.
     */
    public function storeCaption($arrayValues) {
        $data = $this->db->insert('Images', array('imageId' => $arrayValues['imageId'], 'id' => $arrayValues['id'], 
            'imageName' => $arrayValues['imageName'], 'caption' => $arrayValues['caption']
         ));
        if (!$data) {
            throw new \Exception('Could not store image caption in database.');
        }
    }
    
    /**
     * removes caption for image.
     */
    public function removeCaption($name) {
        $data = $this->db->delete('Images', array('imageName' => $name));
        if (!$data) {
            throw new \Exception('Could not delete image in database.');
        }
    }
    
    /**
     * change description for project.
     */
    public function updateDescription($arrayValues) {
        $data = $this->db->update('Projects', array('description' => $arrayValues['description']), array('id' => $arrayValues['id']));
        if (!$data) {
            throw new \Exception('Could not change the description.');
        }
    }
    
    /**
     * change ecternal location for a project.
     */
    public function updateExternalLocation($arrayValues) {
        $data = $this->db->update('Projects', array('externalLocation' => $arrayValues['externalLocation']), array('id' => $arrayValues['id']));
        if (!$data) {
            throw new \Exception('Could not change the description.');
        }
    }
    
    
    /** update personal info.     **/
 
 
    
    public function updateShortAbout($arrayValues) {
        $data = $this->db->update('users', array('shortAbout' => $arrayValues['about']), array('id' => $arrayValues['id']));
        if (!$data) {
            throw new \Exception('Could not change the description.');
        }
    }
    
    public function updateAbout($arrayValues) {
        $data = $this->db->update('users', array('about' => $arrayValues['description']), array('id' => $arrayValues['id']));
        if (!$data) {
            throw new \Exception('Could not change the description.');
        }
    }
    
    public function updateName($arrayValues) {
        $data = $this->db->update('users', array('firstName' => $arrayValues['firstName'], 
            'lastName' => $arrayValues['lastName']), array('id' => $arrayValues['id']));
        if (!$data) {
            throw new \Exception('Could not change name.');
        }
    }

    public function updateContact($arrayValues) {
        $data = $this->db->update('users', array('email' => $arrayValues['email'], 
            'phoneNumber' => $arrayValues['phoneNumber']), array('id' => $arrayValues['id']));
        if (!$data) {
            throw new \Exception('Could not change the contact.');
        }
    }
    
    public function updateUsername($arrayValues) {
        $data = $this->db->update('users', array('username' => $arrayValues['username']), array('id' => $arrayValues['id']));
        if (!$data) {
            throw new \Exception('Could not change the username.');
        }
    }

    public function updatePassword($arrayValues) {
        $data = $this->db->update('users', array('password' => $arrayValues['password']), array('id' => $arrayValues['id']));
        if (!$data) {
            throw new \Exception('Could not change the password.');
        }
    }
    
    public function getDB() {
        return $this->db;
    }
    
}

?>
