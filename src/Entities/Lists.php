<?php
namespace Sources\Entities;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="lists")
 */
class Lists {

  /**
   *  @ORM\Id
   *  @ORM\Column (type="integer") 
   */
  protected $id;
  
  /** 
  * @ORM\Column(type="string") 
  */
  protected $value;
  
  
  function __construct() {
    
  }
  function getId() {
    return $this->id;
  }

  function getValue() {
    return $this->value;
  }

  function setId($id): void {
    $this->id = $id;
  }

  function setValue($value): void {
    $this->value = $value;
  }


}
