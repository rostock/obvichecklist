<?php
namespace Sources\Entities;

/*
 * The MIT License
 *
 * Copyright 2020 Tim Balschmiter.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Listelements stellt die Options für die unterschiedlichen DropDown-Felder bereit.
 *
 * @author Tim Balschmiter
 */

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="listelement")
 */
class Listelement {
  
  /**
   *  @ORM\Id
   *  @ORM\Column (type="integer") 
   *  @ORM\GeneratedValue
   */
  protected $elementId;
  
  /**
   *  @ORM\Column (type="integer") 
   */
  protected $listId;
  
  /** 
  * @ORM\Column(type="string") 
  */
  protected $value;
  
  
  public function __construct($listId, $value) {
    $this->listId = $listId;
    $this->value = $value;
  }
  
  public function getlistId() {
    return $this->listId;
  }
  
  public function setListId($listId) {
    $this->listId = $listId;
  }
  
  public function getElementId() {
    return $this->elementId;
  }
  
  public function setElementId($elementId) {
    $this->elementId = $elementId;
  }
    
  public function getValue() {
    return $this->value;
  }

  public function setValue($value) {
    $this->value = $value;
  }
  
}
