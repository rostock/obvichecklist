<?php
namespace Sources\Controller;

class Options {
  
  protected $options;
  protected $activeElementId;
  protected $entityManager;
  
  function __construct($entityManager, $listId, $activeElementId) {
    $this->entityManager = $entityManager;
    $this->options = [];
    $this->activeElementId = $activeElementId;
    
    $qb = $this->entityManager->createQueryBuilder();
    $qb->select('u')
       ->from('Sources\Entities\Listelement','u')
       ->where('u.listId = :id')
       ->setParameter('id', $listId);
    $results = $qb->getQuery()->getResult();
    
    foreach ($results as $result) {
      $value = [];
      $value['elementId']  = $result->getId();
      $value['value'] = $result->getValue();
      array_push($this->options, $value);
    }
  }

  public function getHTMLCode() {
    $htmlCode = '';
    foreach ($this->options as $option) {
      if($option['elementId'] == $this->activeElementId) {
        $htmlCode = $htmlCode . '<option value="' . $option['elementId'] . '" selected>' . $option['value'] . '</option>';
      } else {
        $htmlCode = $htmlCode . '<option value="' . $option['elementId'] . '">' . $option['value'] . '</option>';
      }
    }    
    return $htmlCode;
  }
}
