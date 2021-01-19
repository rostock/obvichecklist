<?php
namespace Sources\Controller;


class Text {
  
  private $label;
  private $description;
  private $area;
  private $id;
  private $category;
  private $machineCategory;
  private $value;
  private $entityManager;
  const idField = 1; //als Konfiguration in der Datenbank aufnehmen
  
  function __construct($dbField, $knummer, $entityManager) {
    
    $this->entityManager = $entityManager;
    $this->label = $dbField->getLabel();
    $this->description = $dbField->getDescription();
    $this->area = $dbField->getArea();
    $this->id = $dbField->getId();
    $machineCategory = str_replace(" ","_",$dbField->getCategory());
    $machineCategory = preg_replace('/[^A-Za-z0-9\_]/', '', $machineCategory); 
    $this->machineCategory = $machineCategory;
    $this->category = $dbField->getCategory();
    
    if (isset($knummer)) {
      $value = new FieldValue($knummer, $this->id, $this->entityManager);
      $this->value = $value->getValue();
    }
  }
  
  function getArea() {
    return $this->area;
  }

  function getId() {
    return $this->id;
  }

  function getHTMLCode() {
    $code = '<div class="formElement" fieldCategory="' . $this->machineCategory . '">
                    <div class="form-group">
                      <label title="' . $this->description . '" for="' . $this->id . '">' . $this->id . ') ' . $this->label . '</label>
                      <input kind="text" type="text" class="form-control" id="' . $this->id . '" value="' . $this->value . '" ' . $this->disabled(). '>
                    </div>
                  </div>';
    return $code;
  }
  
  function disabled() {
    if($this->getId() == self::idField && isset($this->value)) {
      return "disabled";
    }
  }
}
