<?php
require_once "bootstrap.php";
require_once 'src/Entities/Inhalt.php';
require_once 'src/Entities/Anmerkungen.php';
require_once 'src/Entities/Listelement.php';
require_once 'src/Entities/Metadata.php';
?>
<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" href="lib/bootstrap-4.5.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="images/icons/bootstrap-icons.css">
    <link rel="stylesheet"  href="lib/jquery-ui-1.12.1.custom/jquery-ui.css">
    <link rel="stylesheet" href="css/custom.css">
    <title>ÖBVI Checkliste - Liste</title>
  </head>
  <body>
    <header>
      <nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">ÖBVI Checklist</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-item nav-link" href="conf.php" title="Konfiguration"><i class="bi bi-gear"></i></a>
          </div>  
          <div class="navbar-nav">
            <a class="nav-item nav-link" id="deleteBtn" title="Löschen"><i class="bi bi-trash"></i></a>
          </div>  
        </div>
      </nav>
    </header> 
    <div class="spinnerbox">
      <div class="spinner"></div>
    </div>  
    <main>  
      <table class="table">
        <thead>
          <tr>
            <th></th>  
            <th scope="col">K-Nummer</th>
            <th scope="col">Auswertung</th>
            <th scope="col">Fehler (Gesamt/übernahmerelevant)</th>
            <th scope="col">Vermessungsstelle</th>
            <th scope="col">Eingetragen am/von</th>
            <th scope="col">Aktualisiert am/von</th>
            <th scope="col">Anzahl Bearbeitungen</th>
          </tr>
        </thead>
        <tbody>
            <?php 
              //alle K-Nummern ausgeben
              $query = $entityManager->createQuery('SELECT distinct(u.knummer) FROM Sources\Entities\Inhalt u');
              $results = $query->getResult();
              foreach ($results as $key => $value) {
                //Vermessungsstelle ermitteln
                $query = $entityManager->createQuery('SELECT u.value FROM Sources\Entities\Inhalt u where u.knummer = :id and u.fieldId = 2' );
                $query->setParameter('id', $value["1"]);
                $vermessungsstelle = $query->getResult();
                //Auswertung
                $query = $entityManager->createQuery('SELECT u.value FROM Sources\Entities\Inhalt u where u.knummer = :id and u.fieldId = 65' );
                $query->setParameter('id', $value["1"]);
                $auswertung = $query->getResult();

                echo "<tr>";
                  echo '<td><input type="checkbox" class="checker" id="' . $value['1'] . '" name="horns"></td>';
                  echo '<th scope="row"><a href="index.php?knummer=' . $value['1'] . '">' . $value['1'] . '</a></th>';
                  echo '<td>' . getListValue($auswertung[0]['value'], $entityManager) . '</td>';
                  echo '<td>' . getErrors($value['1'], $entityManager) . '</td>';
                  echo '<td>' . getListvalue($vermessungsstelle[0]['value'], $entityManager) . '</td>';
                  echo '<td>' . getCreated($value['1'], $entityManager) . '</td>';
                  echo '<td>' . getUpdated($value['1'], $entityManager) . '</td>';
                  echo '<td>' . getCountUpdates($value[1], $entityManager). '</td>';
                echo "</tr>";
              };


              function getVermessungsstelle($id, $entityManager) {
                $listElement = $entityManager->find('listelement', $id);              
                $vermesser = $listElement->getValue();
                return $vermesser;
              }

              function getErrors ($knummer, $entityManager) {
                $query = $entityManager->createQuery('SELECT count(u.value) FROM Sources\Entities\Inhalt u where u.knummer = :id and u.value = 4 or u.value = 3 and u.knummer = :id' );
                $query->setParameter('id', $knummer);
                $res = $query->getResult();

                $query = $entityManager->createQuery('SELECT count(u.value) FROM Sources\Entities\Inhalt u where u.knummer = :id and u.value = 4' );
                $query->setParameter('id', $knummer);
                $result = $query->getResult();

                return $res[0][1] . "/" . $result[0][1];
              }

              function getCountUpdates($knummer, $entityManager) {
                $query = $entityManager->createQuery('SELECT count(u.knummer) FROM Sources\Entities\Metadata u where u.knummer = :id' );
                $query->setParameter('id', $knummer);
                $res = $query->getResult();

                return $res[0][1];
              }

              function getCreated($knummer, $entityManager) {

                $queryBuilder = $entityManager->createQueryBuilder();
                $queryBuilder->select('u.bearbeiter, u.datetime')
                  ->from('Sources\Entities\Metadata',' u')
                  ->where('u.knummer = :id')
                  ->andWhere('u.type = :type')
                  ->setParameter('id', $knummer)
                  ->setParameter('type', 'Erstellung');
                $res = $queryBuilder->getQuery()->getResult();

                if(empty($res)) {
                  return 'keine Metadaten gefunden';
                } else {
                  $datetime = $res[0]['datetime']->format('Y-m-d H:i:s');
                  $bearbeiter = getListValue($res[0]['bearbeiter'], $entityManager);
                  return  $datetime . "/" . $bearbeiter;
                }
              }

              function getUpdated($knummer, $entityManager) {
                $queryBuilder = $entityManager->createQueryBuilder();
                $queryBuilder->select('u.bearbeiter, u.datetime')
                  ->from('Sources\Entities\Metadata',' u')
                  ->where('u.knummer = :id')
                  ->andWhere('u.type = :type')
                  ->setParameter('id', $knummer)
                  ->setParameter('type', 'Aktualisierung')
                  ->orderBy('u.datetime', 'DESC');

                $res = $queryBuilder->getQuery()->getResult();

                if(count($res) > 0) {
                  $datetime = $res[0]['datetime']->format('Y-m-d H:i:s');
                  $bearbeiter = getListValue($res[0]['bearbeiter'], $entityManager);
                  return  $datetime . "/" . $bearbeiter;
                } else {
                  return "keine Metadaten gefunden";
                }
              }

              function getListValue($id, $entityManager) {
                $queryBuilder = $entityManager->createQueryBuilder();
                $queryBuilder->select('u.value')
                  ->from('Sources\Entities\Listelement',' u')
                  ->where('u.id = :id')
                  ->setParameter('id', $id);

                $res = $queryBuilder->getQuery()->getResult();

                return $res[0]['value'];
              }


            ?>
        </tbody>
      </table>
    </main>
    <footer class="text-muted">
      <div class="container">
        <p class="float-right">
          <a href="#">Nach oben</a>
        </p>
      </div>
    </footer>  
    
    <script src="lib/jquery-3.5.1/jquery-3.5.1.min.js"></script>
    <script src="lib/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
    <script src="lib/bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
     <script src="js/deleteItem.js"></script>
    
  </body>
</html>
