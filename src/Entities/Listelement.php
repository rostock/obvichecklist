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
  protected $elementId;
  
  /**
   *  @ORM\Column (type="integer") 
   */
  protected $listId;
  
  /** 
  * @ORM\Column(type="string") 
  */
  protected $value;
  
  
  public function __construct($listId, $value) {
    $this->listId = $listId;
    $this->value = $value;
  }
  
  public function getlistId() {
    return $this->listId;
  }
  
  public function setListId($listId) {
    $this->listId = $listId;
  }
  
  public function getElementId() {
    return $this->elementId;
  }
  
  public function setElementId($elementId) {
    $this->elementId = $elementId;
  }
    
  public function getValue() {
    return $this->value;
  }

  public function setValue($value) {
    $this->value = $value;
  }
  
}
