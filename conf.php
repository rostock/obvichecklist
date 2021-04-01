<!doctype html>
<?php
require_once "bootstrap.php";
require "vendor/autoload.php";
?>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" href="lib/bootstrap-4.5.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet"  href="lib/jquery-ui-1.12.1.custom/jquery-ui.css">
    <link rel="stylesheet" href="css/custom.css">
    <title>ÖBVI Checkliste - Konfiguration</title>
  </head>
  <body>
    <header>
      <nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">ÖBVI Checklist - Konfiguration</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-item nav-link" href="conf.php" title="Konfiguration"><i class="bi bi-gear"></i></a>
          </div>     
        </div>
      </nav>
    </header>  
    <main>
        <div class=""container">  
          <div class="jumbotron">
            <p>Eingabefelder</p>
            <a class="btn btn-primary btn-lg" href="confDB.php?type=fields&list=null" role="button" title="Feld-Konfiguration">Konfigurieren</a>
            <hr class="my-4">
          </div>
        </div>
        <div class=""container">  
          <div class="jumbotron">
            <p>Listen</p>
            <a class="btn btn-primary btn-lg" href="confDB.php?type=lists&list=null" role="button" title="Feld-Konfiguration">Konfigurieren</a>
            <hr class="my-4">
          </div>
        </div>
        <div class=""container">  
          <div class="jumbotron">
            <p>Listenelemente</p>
            <?php
            $qb = $entityManager->createQueryBuilder();
            $qb->select('u')
              ->from('Sources\Entities\Lists','u');
            $results = $qb->getQuery()->getResult();
            foreach ($results as $result) {
              echo '<label for="list' . $result->getId() . '">' . $result->getValue() . ': </label>';
              echo '<a id="' . $result->getId() . '" class="btn btn-primary btn-lg" href="confDB.php?type=listelement&list=' . $result->getId() . '" role="button" title="Feld-Konfiguration">Konfigurieren</a>';
              echo '<br>';
            }
            ?>
            <hr class="my-4">
          </div>
        </div>
    </main>
    <footer class="text-muted">
      <div class="container">
        <p class="float-right">
          <a href="#">Nach oben</a>
        </p>
      </div>
    </footer>  
    
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="lib/jquery-3.5.1/jquery-3.5.1.min.js"></script>
    <script src="lib/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="lib/bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/tooltip.js"></script>
    <script src="js/autocomplete.js"></script>
    <script src="js/createItem.js"></script>
  </body>
</html>
