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
  * @ORM\Column(type="boolean")
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
  
  public function __construct($id, $label, $description, $category, $type, $listId, $comments, $commentson, $area) {
    $this->id = $id;
    $this->label = $label;
    $this->description = $description;
    $this->category = $category;
    $this->type = $type;
    $this->listId = $listId;
    $this->comments = $comments;
    $this->commentson = $commentson;
    $this->area = $area;
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

  function setId($id): void {
    $this->id = $id;
  }

  function setLabel($label): void {
    $this->label = $label;
  }

  function setDescription($description): void {
    $this->description = $description;
  }

  function setCategory($category): void {
    $this->category = $category;
  }

  function setType($type): void {
    $this->type = $type;
  }

  function setListId($listId): void {
    $this->listId = $listId;
  }

  function setComments($comments): void {
    $this->comments = $comments;
  }

  function setCommentson($commentson): void {
    $this->commentson = $commentson;
  }

  function setArea($area): void {
    $this->area = $area;
  }
}



