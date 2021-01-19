# obvichecklist

Installation

-PHP - Bibliotheken
-- im root-Ordner "composer install" ausführen
-- die Vendor Ordner werden erstellt

- SQL-lite Datenbank anlegen
-- im Root Ordner "vendor/bin/doctrine orm:schema-tool:create" ausführen
-- im Browser "http://domain/initValues.php" aufrufen, dadurch werden die Excel Daten in die DB überführt

- JS-Bibiotheken hinzufügen
-- im root-Ordner den Ordner "lib" erstellen
-- Bootstrap 4.5.2 herunterladen (https://github.com/twbs/bootstrap/releases/download/v4.5.3/bootstrap-4.5.3-dist.zip)
-- jQuery 3.5.1 herunterladen (https://code.jquery.com/jquery-3.5.1.min.js)
-- jQuery UI 1.12.1 herunterladen (https://jqueryui.com/download/)
-- Entsprechend dem folgenden Schema im lib-Ordner ablegen

-root
--lib
---bootstrap-4.5.2-dist
---jquery-3.5.1
---jquery-ui-1.12.1.custom

