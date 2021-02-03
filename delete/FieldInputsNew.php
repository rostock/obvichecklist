<?php
namespace Sources\Controller;
/**
 * Description of FieldInputs
 *
 * @author Tim Balschmiter
 */

require_once "bootstrap.php";
require_once 'src/Entities/Listelement.php';
require_once 'src/Entities/Inhalt.php';
require_once 'src/Entities/Anmerkungen.php';
require_once 'src/Entities/Fields.php';


class FieldInputsNew {
  
  protected $fields;
  protected $entityManager;
  protected $type;
  
  function __construct($entityManager, $knummer) {
    $this->entityManager = $entityManager;
    $query = $this->entityManager->createQuery('SELECT u FROM fields u');
    $results = $query->getResult();
    $this->checkType($knummer ?? null);
  }
  
  
  private function checkType ($knummer) {
    $query = $this->entityManager->createQuery('SELECT distinct(u.knummer) FROM inhalt u');
    $results = $query->getResult();

    if(in_array_R($knummer,$results)) {
      $this->type = 'update';
    } else {
      $this->type = 'create';
    }
  }
  
  public function getMainHTML($knummer) {
    
    $query = $this->entityManager->createQuery('SELECT distinct(u.knummer) FROM inhalt u');
    $results = $query->getResult();

    if(in_array_R($knummer,$results)) {
      $this->type = 'update';
      $form = $this->getEditableForm($knummer); 
      
    } else {
      $form = $this->getEmptyForm();
      
    }
    return $form;  
  }
      
  private function getEmptyForm() {
    $htmlCode = "";
    $value = "";
   
    foreach ($this->fields as $field ) {
      $className = str_replace(" ","_",$field[4]);
      $className = preg_replace('/[^A-Za-z0-9\_]/', '', $className); 
      
      if($field[5] == "Text") {
        $value = '<div class="formElement" fieldCategory="' . $className . '">
                    <div class="form-group">
                      <label title="' . $field[3] . '" for="' . $field[1] . '">' .$field[1]. ') ' .$field[2]. '</label>
                      <input kind="text" type="text" class="form-control" id="' . $field[1] . '">
                    </div>
                  </div>';
      }
      if($field[5] === 'Auswahl') {
        $value = '<div class="formElement inputField" fieldCategory="' . $className . '">
                    <div class="form-group">
                      <label title="' . $field[3] . '" for="' . $field[1] . '">' .$field[1]. ') ' .$field[2]. '</label>
                      <select kind="auswahl" class="form-control selectBox" id="' . $field[1] . '" changeAttr="' . $field[8] . '">' .
                        $this->htmlOptions($field[6])
                      . '</select>
                    </div>'; 
        if($field[7] == 'Ja') {
          $value = $value . '<textarea kind="comment" style="display:none" class="form-control" id="comment_' . $field[1] . '" rows="5"></textarea>';
        }          
        $value = $value . '</div>';
      }
      if($field[5] === 'Autocomplete') {
        $value = '<div class="formElement" fieldCategory="' . $className . '">
                    <div class="form-group">
                      <label title="' . $field[3] . '"  for="' . $field[1] . '">' .$field[1]. ') ' .$field[2]. '</label>
                      <input kind="autocomplete" value="" type="text" list="' . $field[6] . '" class="form-control autocomplete" id="' . $field[1] . '">
                    </div>
                  </div>';        
      }
      $htmlCode = $htmlCode . $value;
    }
    return $htmlCode;
  }
  
  /*
   * Editor
   */
  private function getEditableForm ($knummer) {
    $htmlCode = "";
    $value = "";
   
    $query_inhalt = $this->entityManager->createQuery('SELECT u FROM inhalt u where u.knummer = :id');
    $query_inhalt->setParameter('id', $knummer);
    $query_comment = $this->entityManager->createQuery('SELECT u FROM anmerkungen u where u.knummer = :id');
    $query_comment->setParameter('id', $knummer);
    $results_inhalt = $query_inhalt->getResult();
    $results_comment = $query_comment->getResult();
    
    
    foreach ($this->fields as $field ) {
      $className = str_replace(" ","_",$field[4]);
      $className = preg_replace('/[^A-Za-z0-9\_]/', '', $className); 
      
      if($field[5] == "Text" && $field[1] === 1) {
        $value = '<div class="formElement" fieldCategory="' . $className . '">
                    <div class="form-group">
                      <label title="' . $field[3] . '" for="' . $field[1] . '">' .$field[1]. ') ' .$field[2]. '</label>
                      <input kind="text" type="text" class="form-control" id="' . $field[1] . '" value="' . $knummer . '" disabled>
                    </div>
                  </div>';
      } 
      if($field[5] == "Text" && $field[1] !== 1) {
        $value = '<div class="formElement" fieldCategory="' . $className . '">
                    <div class="form-group">
                      <label title="' . $field[3] . '" for="' . $field[1] . '">' .$field[1]. ') ' .$field[2]. '</label>
                      <input type="text" class="form-control" id="' . $field[1] . '" value="' . $this->findValue($results_inhalt, $field[1]) . '">
                    </div>
                  </div>';
      }
      if($field[5] === 'Auswahl') {
        $value = '<div class="formElement inputField tags" fieldCategory="' . $className . '">
                    <div class="form-group">
                      <label title="' . $field[3] . '" for="' . $field[1] . '">' .$field[1]. ') ' .$field[2]. '</label>
                      <select kind="auswahl" class="form-control selectBox" id="' . $field[1] . '" changeAttr="' . $field[8] . '">' .
                        $this->htmlOptions($field[6], $this->findValue($results_inhalt, $field[1]))
                      . '</select>
                    </div>';
        
        if($field[7] == 'Ja') {
          if($this->checkChangeAttr($field[8], $this->findValue($results_inhalt, $field[1]))) {
            $value = $value . '<textarea kind="comment" class="form-control" id="comment_' . $field[1] . '" rows="5">' . $this->findValue($results_comment, $field[1]). '</textarea>';
          } else {
            $value = $value . '<textarea kind="comment" style="display:none" class="form-control" id="comment_' . $field[1] . '" rows="5">' . $this->findValue($results_comment, $field[1]). '</textarea>';
          }
        }          
        $value = $value . '</div>';
      }
      
      if($field[5] === 'Autocomplete') {
        $value = '<div class="formElement inputField tags" fieldCategory="' . $className . '">
                    <div class="form-group">
                      <label for="' . $field[1] . '">' .$field[1]. ') ' .$field[2]. '</label>
                      <input kind="autocomplete" value="' . $this->findValue($results_inhalt, $field[1]) . '" type="text" list="' . $field[6] . '" class="form-control autocomplete" id="' . $field[1] . '"  disabled>
                      <span class="remove" parent="' . $field[1] . '"><a href="#">remove</a></span>
                    </div>'; 
        
        
        if($field[7] == 'Ja') {
          $value = $value . '<textarea style="display:none" class="form-control" id="comment_' . $field[1] . '" rows="5">' . $this->findValue($results_comment, $field[1]). '</textarea>';
        }          
        $value = $value . '</div>';
      }
      
      $htmlCode = $htmlCode . $value;
    }
    return $htmlCode;
  }
  
  private function checkChangeAttr($stringList, $value) {
    $list = explode(',',$stringList);
    if(in_array($value,$list)) {
      return true;
    } else {
      return false;
    }
  }
  
  private function findValue($arrayList, $fieldId) {
    foreach ($arrayList as $key => $value) {
      if($value->getFieldId() === $fieldId) {
        return $value->getValue();
      }
    }
    return null;
  }
  
  
  private function htmlOptions($listId, $activeElement = null) {
    $htmlOptions = "";
    foreach ($this->options as $option) {
      if($option[0] == $listId) {
        if($option[1] === $activeElement) {
          $htmlOptions = $htmlOptions . '<option value="' . $option[1] . '" selected>' . $option[2] . '</option>';
        } else {
          $htmlOptions = $htmlOptions . '<option value="' . $option[1] . '">' . $option[2] . '</option>';
        }
      }
    }
    
    return $htmlOptions;
  }
  
  private function buildOptions() {
    $options = [];
    $elementsRepository = $this->entityManager->getRepository('Listelement');
    $elements = $elementsRepository->findAll();
    foreach ($elements as $element) {
      $option = [];
      $option[0] = $element->getlistId();
      $option[1] = $element->getId();
      $option[2] = $element->getValue();
      array_push($options,$option);
    }
    return $options;
  }
  
  public function getType() {
    return $this->type;
  }
  
  public function getSelect($listId, $knummer) {
    
  }
  
  
  public function getFinalBtn() {
    
    return  '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">' . $value . '</button>';
  }
}
