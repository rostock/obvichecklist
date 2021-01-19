<?php
namespace Sources\Controller;

class Filter {
  
  private $filter;
  private $entityManager;
  
  function __construct($entityManager) {
    $this->filter = [];
    $this->entityManager = $entityManager;
    
    $qb = $this->entityManager->createQueryBuilder();
    $qb->select('u.value')
       ->from('Sources\Entities\Listelement','u')
       ->where('u.listId = 1');
    $results = $qb->getQuery()->getResult();
    
    foreach ($results as $result) {
      array_push($this->filter, $result['value']);
    }
    $this->filter = array_unique($this->filter);
  }

  function getCheckboxHTMLCode() {
    $htmlCode = "";
    $i = 1;
    foreach ($this->filter as $filt) {
      if($filt != NULL or $filt != "") {
        $htmlCode = $htmlCode . '<div>
              <input type="checkbox" class="filterAttr" name="' . $i .'" checked>
              <label for="' . $i . '">&nbsp' . $filt . ' <span class="badge badge-primary summarySpan" name="' . $i . '">0</span>&nbsp&nbsp&nbsp</label>       
            </div>';
      }
      $i++;
    }
      
    return $htmlCode;
  }
  
  function getDefaultHTMLCode() {
    $htmlCode = "";
    $i = 1;
    foreach ($this->filter as $filt) {
      if($filt != NULL or $filt != "") {
        $htmlCode = $htmlCode . '<div>
              <label>&nbsp' . $filt . ' <span class="badge badge-primary summarySpan" name="' . $i . '">0</span>&nbsp&nbsp&nbsp</label>       
            </div>';
      }
      $i++;
    }
      
    return $htmlCode;
  }
}
