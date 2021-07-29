<?php

namespace App\Models\Entity;

/**
 * @Entity @Table(name="categories")
 **/
class Category {

    /**
     * @var int
     * @Id @Column(type="integer") 
     * @GeneratedValue
     */
    public $id;

    /**
     * @var string
     * @Column(type="string") 
     */
    public $name;

    /**
     * @var string
     * @Column(type="string") 
     */
    public $description;

    /**
     * @return int id
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @return string name
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @return string description
     */
    public function getDescription() {
        return $this->description;
    }    

    /**
     * @return App\Models\Entity\Category
     */
    public function setName($name){
        $this->name = $name;
        return $this;  
    }

    /**
     * @return App\Models\Entity\Category
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * @return App\Models\Entity\Category
     */
    public function getValues() {
        return get_object_vars($this);
    }
}