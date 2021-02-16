<?php
namespace Sources\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="listelement")
 */
class Listelement {
  
  /**
   *  @ORM\Id
   *  @ORM\Column (type="integer") 
   *  @ORM\GeneratedValue
   */
  protected $id;
  
  /**
   *  @ORM\Column (type="integer") 
   */
  protected $listId;
  
  /** 
  * @ORM\Column(type="string") 
  */
  protected $value;
  
  /** 
  * @ORM\Column(type="boolean", options={"default": 1})
  */
  protected $active;
  
  
  public function __construct($listId, $value) {
    $this->listId = $listId;
    $this->value = $value;
    $this->active = TRUE;
  }
  
  function getActive() {
    return $this->active;
  }

  function setActive($active): void {
    $this->active = $active;
  }

    public function getlistId() {
    return $this->listId;
  }
  
  public function setListId($listId) {
    $this->listId = $listId;
  }
  
  public function getId() {
    return $this->id;
  }
  
  public function setId($id) {
    $this->id = $id;
  }
    
  public function getValue() {
    return $this->value;
  }

  public function setValue($value) {
    $this->value = $value;
  }
  
}
