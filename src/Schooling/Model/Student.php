<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   02/02/2020
 * @time  :   13:32
 */

namespace App\Schooling\Model;


class Student {
    private $id;
    private $name;
    
    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * @param mixed $id
     */
    public function setId($id): void {
        $this->id = $id;
    }
    
    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * @param mixed $name
     */
    public function setName($name): void {
        $this->name = $name;
    }
    
    
}