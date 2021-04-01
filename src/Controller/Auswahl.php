<?php
namespace Sources\Controller;

class Auswahl {
    
  private $label;
  private $description;
  private $area;
  private $id;
  private $category;
  private $listId;
  private $value;
  private $commentvalue;
  private $comments;
  private $commentson;
  private $entityManager;
  private $machineCategory;
  
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
    $this->listId = $dbField->getListId();
    $this->comments = $dbField->getComments();
    $this->commentson = $dbField->getCommentson();
    $this->value = null;
    
    if (isset($knummer)) {
      $value = new FieldValue($knummer, $this->id, $this->entityManager);
      $this->value = $value->getValue();
    }
    
    if (isset($knummer) && isset($this->comments) ) {
      $value = new CommentValue($knummer, $this->id, $this->entityManager);
      $this->commentvalue = $value->getValue();
    }
  }
  
  function getArea() {
    return $this->area;
  }

  function getId() {
    return $this->id;
  }

  function getHTMLCode() {
    $options = new Options($this->entityManager, $this->listId, $this->value);
    $code = '<div class="formElement inputField" fieldCategory="' . $this->machineCategory . '">
                    <div class="form-group">
                      <label title="' . $this->description . '" for="' . $this->id . '">' .$this->id. ') ' . $this->label . '</label>
                      <select kind="auswahl" class="form-control selectBox" id="' . $this->id . '" changeAttr="' . $this->commentson . '">' 
                      .  $options->getHTMLCode() .
                      '</select>
                    </div>'; 
    if($this->comments != 0) {
      $code = $code . '<textarea kind="comment"' . $this->checkChangeAttr() . ' class="form-control" id="comment_' . $this->id . '" rows="5">' . $this->commentvalue . '</textarea>';
    }          
    $code = $code . '</div>';
    return $code;
  }
  
  function checkChangeAttr() {
    $list = explode(',', $this->commentson); 
    if(in_array($this->value,$list)) {
      return '';
    } else {
      return 'style="display:none"';
    };
  }
}

