<?php

namespace App\Models\Entity;

/**
 * @Entity @Table(name="items")
 **/
class Item {

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
     * @Column(type="integer") 
     */
    public $categoryId;


    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getCategoryId() {
        return $this->categoryId;
    }    

    public function setName($name){
        $this->name = $name;
        return $this;  
    }

    public function setCategoryId($categoryId) {
        $this->categoryId = $categoryId;
        return $this;
    }
}