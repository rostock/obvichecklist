<?php
namespace Sources\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="metadata")
 */
class Metadata {
    
  /** 
  * @ORM\Column(type="string")
  */
  protected $knummer;
  
  
  /** 
  * @ORM\Id*
  * @ORM\Column(type="integer")
  * @ORM\GeneratedValue
  */
  protected $id;
  
  /** 
  * @ORM\Column(type="integer") 
  */
  protected $bearbeiter;
  
  /** 
  * @ORM\Column(type="datetime", columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL") 
  * @ORM\Version 
  */
  protected $datetime;
  
  /** 
  * @ORM\Column(type="string") 
  */
  protected $type;

  public function getBearbeiter() {
    return $this->bearbeiter;
  }

  public function setBearbeiter($value) {
    $this->bearbeiter = $value;
  }
  
  public function getType() {
    return $this->type;
  }

  public function setType($value) {
    $this->type = $value;
  }
  
  public function getKnummer() {
    return $this->knummer;
  }

  public function setKnummer($knummer) {
    $this->knummer = $knummer;
  }
  
  public function getId() {
    return $this->id;
  }
  
  public function getDatetime() {
    return $this->datetime;
  }
}
