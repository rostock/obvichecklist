<?php
namespace Sources\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="inhalt")
 */
class Inhalt {
  /** 
  * @ORM\Id*
  * @ORM\Column(type="string")
  */
  protected $knummer;
    
  /** 
  * @ORM\Id*
  * @ORM\Column(type="integer")
  */
  protected $fieldId;
  
  /** 
  * @ORM\Column(type="string") 
  */
  protected $value;

  public function getValue() {
    return $this->value;
  }

  public function setValue($value) {
    $this->value = $value;
  }
  
  public function getFieldId() {
    return $this->fieldId;
  }

  public function setFieldId($fieldId) {
    $this->fieldId = $fieldId;
  }
  
  public function getKnummer() {
    return $this->knummer;
  }

  public function setKnummer($knummer) {
    $this->knummer = $knummer;
  }
}
