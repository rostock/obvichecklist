<?php
namespace Sources\Controller;

class CommentValue {
  
  protected $value;
  private $entityManager;
  
  function __construct($knummer, $fieldId, $entityManager) {
    $this->entityManager = $entityManager;
    
    $qb = $this->entityManager->createQueryBuilder();
    $qb->select('u')
       ->from('Sources\Entities\Anmerkungen','u')
       ->where('u.knummer = :kid')
       ->andWhere('u.fieldId = :fid')
       ->setParameter('kid', $knummer)
       ->setParameter('fid', $fieldId);
    $results = $qb->getQuery()->getResult();
    
    if($results) {
      $this->value = $results[0]->getValue();
    }
  }
  
  function getValue() {
    return $this->value;
  }
}
