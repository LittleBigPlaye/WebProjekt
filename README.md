# Projekt: MaskYourFace - Webentwicklung

## Webseite in Betrieb nehmen

### Klonen des Repositorys

Als erstes muss dieses Repository geklont werden und in einem Verzeichnis hinterlegt werden, auf dem ein installierter Apache-Dienst den PHP-Code interpretieren und ausführen kann. (z. B. htdocs Ordner)

### Importieren der Datenbank

Um die Website in Betrieb nehmen zu können, muss zunächst eine SQL-Datei im phpmyadmin importiert werden. Diese SQL-Datei erstellt die notwendige Datenbank, mit 21 Produkten und 2 Nutzern.

Die zu importierende Datei finden Sie im Repository unter:  
>src/database/database_initialize.sql

### Nutzung der Vorgefertigten Benutzer  

Nach erfolgreichem Importieren der Datenbank, stehen Ihnen nun 2 Benutzer zur Verfügung um Mask Your Face zu testen.  

>**Nutzer 1**  
>Kontotyp: Admin  
>E-Mail: admin@admin.de  
>Passwort: Admin12345678!
<!--  -->
>**Nutzer 2**  
>Test
>Email: test@nutzer.de  
>Passwort: Test12345678!
  
Der Unterschied zwischen dem Nutzer und dem Administrator sehen Sie in der Navigationsleiste.

Der Nutzer findet dort nur "Mein Konto" und der Administrator hat ein aufklappbares Element "Administration". Dort finden sich die Punkt "Mein Konto", "Produkt anlegen" und "Benutzerverwalten".

Bei Bedarf können auch weitere Benutzer registriert werden. Beachten Sie hierbei, dass diese standardmäßig die Rolle "Benutzer" zugeordnet bekommen und somit **keine** administartoven Rechte haben.

## Kurzübersicht: Ordnerstruktur

### /assets
In /assets sind folgende Dateien enthalten:
- css - styles (styles)
- javascript - Dateien (javascript)
- bilder (images)
- Schriftart(en) (fonts)

### /config
In /config sind folgende Dateien enthalten:
- Datenbankkonfiguration (database.php)
- Bildeinstellungen (für Uploads) (imageSettings.php)
- allgemeine Projekteinstellungen (init.php)
- Namen der Produkte, die auf der Startseite in der ersten Produktreihe angezeigt werden (indexProductConfiguration.txt)

### /controllers
In /controllers sind die jeweiligen Controller gelistet:

- Accountverwaltung / Registrierung / Nutzeradministration (accountsController.php)
- Fehlermeldungen (errorsController.php)
- Warenkorb und Bestellungen (ordersController.php)
- allgemeine Seiten wie Startseite, Impressum, Login (pagesController.php)
- Produktverwaltung (Anlage, Bearbeitung) (productManagementController.php)
- Produktansichten (Suche, Ansicht, Markenübersicht) (productsController.php)

### /core
In /core befinden sich die Basisklassen für Controller und Models

- Basis Model (Grundlegende Funktionen für Datenbankzugriff via Models) (baseModelClass.php)
- Grundlegende Funktionen für alle Controller (controllerClass.php)

### /docs
In /docs befindet sich die Dokumentation des Projektes. Die Dokumentation kann über einen Link im Footer erreicht werden

### /models
In /models befinden sich die models, für den Datenbankzugriff. Im Gegensatz, zu den Tabellen der Datenbank sind die Models im Singular gehalten.

- Tabelle "addresses" (addressClass.php)
- Tabelle "categories" (categoryClass.php)
- Tabelle "images" (imageClass.php)
- Tabelle "logins" (loginClass.php)
- Tabelle "orders" (orderClass.php)
- Tabelle "orderItems" (orderItemClass.php)
- Tabelle "products" (productClass.php)
- Tabelle "productImages" (productImage.php)
- Tabelle "users" (userClass.php)
- Tabelle "vendors" (vendorClass.php)

### /src
In /src sind sowohl die Datenbank als MySQL-Workbench Projekt sowie der Datenbankdump als auch die use cases nochmals als .drawio Datei enthalten. (Die Use-Cases sind ebenfalls in der Dokumentation als Bilder gelistet)

- Datenbankspezifische Dateien (database)
- Use-Case Diagramme (useCases)

### /views
In /views sind die jeweiligen Seiten enthalten. Hierbei sind die Seiten nach den jeweiligen Actions benannt und befinden sich jeweils in einem Ordner, der den Namen der Controller Klasse trägt, in der sich die zugehörige "action"-Methode befindet.

### /index.php
Die Datei /index.php stellt den Einstiegspunkt in das Projekt dar.