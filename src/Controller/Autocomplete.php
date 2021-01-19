<?php
namespace Sources\Controller;

class Autocomplete {
  
  private $label;
  private $description;
  private $area;
  private $id;
  private $category;
  private $listId;
  private $value;
  private $machineCategory;
  private $entityManager;
  
  function __construct($dbField, $knummer, $entityManager) {
    $this->label = $dbField->getLabel();
    $this->entityManager = $entityManager;
    $this->description = $dbField->getDescription();
    $this->area = $dbField->getArea();
    $this->id = $dbField->getId();
    $machineCategory = str_replace(" ","_",$dbField->getCategory());
    $machineCategory = preg_replace('/[^A-Za-z0-9\_]/', '', $machineCategory); 
    $this->machineCategory = $machineCategory;
    $this->category = $dbField->getCategory();
    $this->listId = $dbField->getListId();
    
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
    $user = new ListValue($this->value, $this->entityManager);
    $code = '<div class="formElement" fieldCategory="' . $this->machineCategory . '">
                    <div class="form-group">
                      <label title="' . $this->description . '"  for="' . $this->id . '">' . $this->id . ') ' . $this->label. '</label>
                      <input kind="autocomplete" humanvalue="' . $user->getValue() . '" value="' . $this->value . '" type="text" list="' . $this->listId. '" class="form-control autocomplete" id="' . $this->id . '" ' . $this->disabled(). '>
                        
                    ' . $this->span() . '</div>
                  </div>';       
    return $code;
  }
  
  function disabled() {
    if(isset($this->value)) {
      return "disabled";
    }
  }
  
  function span() {
    if(isset($this->value)) {
      return '<span class="remove" parent="' . $this->id . '"><a href="#">remove</a></span>';
    }
  }
}