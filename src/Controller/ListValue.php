<?php
namespace Sources\Controller;

class ListValue {
  
  protected $value;
  protected $entityManager;
  
  function __construct($id, $entityManager) {
    
    $this->entityManager = $entityManager;
    
    $qb = $this->entityManager->createQueryBuilder();
    $qb->select('u.value')
       ->from('Sources\Entities\Listelement','u')
       ->where('u.id = :kid')
       ->setParameter('kid', $id);
    $results = $qb->getQuery()->getResult();
    foreach ($results as $result) {
      $this->value =$result['value'];
    }
  }
  
  function getValue() {
    return $this->value;
  }

}
