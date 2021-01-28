<?php
require_once "bootstrap.php";
?>
<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" href="lib/bootstrap-4.5.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet"  href="lib/jquery-ui-1.12.1.custom/jquery-ui.css">
    <link rel="stylesheet" href="images/icons/bootstrap-icons.css">
    <link rel="stylesheet" href="css/custom.css">
    <title>ÖBVI Checkliste - Liste</title>
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
    <?php
      $table = new \Sources\Controller\ConfigTable($_GET['type'], $_GET['list'], $entityManager);
      echo $table->getHTMLCode();
    ?>
    </main>
    <footer class="text-muted">
      <div class="container">
        <p class="float-right">
          <a href="#">Nach oben</a>
        </p>
      </div>
    </footer>  
    <?php
      echo $table->getHTMLmodal();
    ?>
    
    <script src="lib/jquery-3.5.1/jquery-3.5.1.min.js"></script>
    <script src="lib/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
    <script src="lib/bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
    <script src="js/conf.js"></script>
    
  </body>
</html>

