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

>**Nutzer 2**  
>Test
>Email: test@nutzer.de  
>Passwort: Test12345678!
  

Der Unterschied zwischen dem Nutzer und dem Administrator sehen Sie in der Navigationsleiste.

Der Nutzer findet dort nur "Mein Konto" und der Administrator hat ein aufklappbares Element "Administration". Dort finden sich die Punkt "Mein Konto", "Produkt anlegen" und "Benutzerverwalten". 

Bei Bedarf können auch weitere Benutzer registriert werden. Beachten Sie hierbei, dass diese standardmäßig die Rolle "Benutzer" zugeordnet bekommen und somit **keine** administartoven Rechte haben.