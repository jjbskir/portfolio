<?php

namespace model\entities;

/**
 * Admin info.
 */
class Admin {
    
    /**
     * private variables
     */
    private $id;
    private $username;
    private $password;
    private $roles;
    
    private $firstName;
    private $lastName;
    private $shortAbout;
    private $about;
    
    private $email;
    private $phoneNumber;
    private $address;
    
    
    /**
     * constructor
     * 
     * gets info from database to create the admin object.
     */
    public function __construct($dbArray) {
        if (isset($dbArray)) {
            $this->id           = $dbArray['id'];
            $this->username     = $dbArray['username'];
            $this->password     = $dbArray['password'];
            $this->roles        = $dbArray['roles'];
            $this->firstName    = $dbArray['firstName'];
            $this->lastName     = $dbArray['lastName'];
            $this->shortAbout   = $dbArray['shortAbout'];
            $this->about        = $dbArray['about'];
            $this->email        = $dbArray['email'];
            $this->phoneNumber  = $dbArray['phoneNumber'];
            $this->address      = $dbArray['address'];
        }
    }
    
    /**
     * getters.
     */
    public function getIdName() {
        return $this->id;
    }
    
    public function getFirstName() {
        return $this->firstName;
    }
    
    public function getLastName() {
        return $this->lastName;
    }

    public function getShortAbout() {
        return $this->shortAbout;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getRoles() {
        return $this->roles;
    }
    
    public function getAbout() {
        return $this->about;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getPhoneNumber() {
        return $this->phoneNumber;
    }
    
    public function getAddress() {
        return $this->address;
    }

}

?>
