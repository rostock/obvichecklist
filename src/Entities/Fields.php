<?php
namespace Sources\Entities;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="fields")
 */
class Fields {
  /** 
  * @ORM\Id*
  * @ORM\Column(type="integer")
  */
  protected $id;
    
  /** 
  * @ORM\Column(type="string")
  */
  protected $label;
    
  /** 
  * @ORM\Column(type="string")
  */
  protected $description;
    
  /** 
  * @ORM\Column(type="string")
  */
  protected $category;
    
  /** 
  * @ORM\Column(type="string")
  */
  protected $type;
    
  /** 
  * @ORM\Column(type="integer")
  */
  protected $listId;
  
  /** 
  * @ORM\Column(type="boolean", options={"default": 0})
  */
  protected $comments;
    
  /** 
  * @ORM\Column(type="string")
  */
  protected $commentson;
  
    
  /** 
  * @ORM\Column(type="string")
  */
  protected $area;
  
  /** 
  * @ORM\Column(type="boolean", options={"default": 1})
  */
  protected $savevalue;
  
  public function __construct() {
    
  }
  
  
  public function setParameters($id, $label, $description, $category, $type, $listId, $comments, $commentson, $area, $savevalue) {
    $this->id = $id;
    $this->label = $label;
    $this->description = $description;
    $this->category = $category;
    $this->type = $type;
    $this->listId = $listId;
    $this->comments = $comments;
    $this->commentson = $commentson;
    $this->area = $area;
    $this->savevalue = $savevalue;
  }

  function getId() {
    return $this->id;
  }

  function getLabel() {
    return $this->label;
  }

  function getDescription() {
    return $this->description;
  }

  function getCategory() {
    return $this->category;
  }

  function getType() {
    return $this->type;
  }

  function getListId() {
    return $this->listId;
  }

  function getComments() {
    return $this->comments;
  }

  function getCommentson() {
    return $this->commentson;
  }

  function getArea() {
    return $this->area;
  }

  public function setId($id): void {
    $this->id = $id;
  }

  public function setLabel($label): void {
    $this->label = $label;
  }

  public function setDescription($description): void {
    $this->description = $description;
  }

  public function setCategory($category): void {
    $this->category = $category;
  }

  public function setType($type): void {
    $this->type = $type;
  }

  public function setListId($listId): void {
    $this->listId = $listId;
  }

  public function setComments($comments): void {
    $this->comments = $comments;
  }

  public function setCommentson($commentson): void {
    $this->commentson = $commentson;
  }
  function getSavevalue() {
    return $this->savevalue;
  }

  function setSavevalue($savevalue): void {
    $this->savevalue = $savevalue;
  }

    public function setArea($area): void {
    $this->area = $area;
  }
}



