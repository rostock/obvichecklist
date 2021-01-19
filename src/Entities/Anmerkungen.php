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
 * Description of Anmerkungen
 *
 * @author Tim Balschmiter
 */
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="anmerkungen")
 */
class Anmerkungen {
    
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
