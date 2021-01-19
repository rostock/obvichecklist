<?php
namespace Sources\Controller;

class Fields {
  
  protected $fields;
  protected $entityManager;
  protected $type;
  private $knummer;
  
  function __construct($entityManager, $knummer) {
    $this->entityManager = $entityManager;
    $this->knummer = $knummer;
    if($this->knummer) {
      $this->type = 'update';
    } else {  
      $this->type = 'create' ;
    }
    $this->buildFields();
  }
  
  private function buildFields() {
    $this->fields = [];
    $qb = $this->entityManager->createQueryBuilder();
    $qb->select('u')
       ->from('Sources\Entities\Fields','u');
    $results = $qb->getQuery()->getResult();
    
    foreach ($results as  $result) {
      switch ($result->getType()) {
        case 'Autocomplete':
          array_push($this->fields, new Autocomplete($result, $this->knummer, $this->entityManager));
          break;
        case 'Auswahl':
          array_push($this->fields, new Auswahl($result, $this->knummer, $this->entityManager));
          break;
        case 'Text': 
          array_push($this->fields, new Text($result, $this->knummer, $this->entityManager));
          break;  
      }
    }
  }
  
  public function getHTMLCode($area) {
    $htmlCode = '';
    foreach ($this->fields as $field) {
      if($field->getArea() == $area) {
        $htmlCode = $htmlCode . $field->getHTMLCode();
      }
    }
    return $htmlCode;
  }

  public function getType() {
    return $this->type;
  }
}




