# FSW_Elternzeit

Web-Oberfläche zur Eingabe und Verwaltung von Elternstunden.

Die Lösung besteht aus zwei Ansichten: 

## (1) Die Ansicht für Eltern (=User)
Diese Ansicht verwenden Eltern, um ihre Elterneinsätze deren Dauer, Datum, Einsatzgebiete sowie individuelle Kommentare und Pensum (20/40h) zu verwalten
Diese Ansicht ist nicht geschützt durch Benutzername & Passwort. Grund: Potenzial für "Vergessen" zu groß.
Die Ansicht ist geschützt durch ein individuelles 10+-stelliges Geheimnis in der URL, welches automatisch und zufällig beim Anlegen der User in der Datenbank generiert wird.

### Preview Useransicht:
![image](https://user-images.githubusercontent.com/11231051/153256098-eff6c018-d7e5-44d3-b5d8-b2b584eb2189.png)


## (2) Die Ansicht für das Sekretariat (=Admin)
Diese Ansicht zeigt die Summen aller Elterneinsätze an. Hierüber können neue Familien angelegt, deren E-Mail-Adressdaten editiert sowie Erinnerungsmails versendet werden.
Diese Ansicht ist geschützt durch Nutzername und Passwort.

### Preview Admin-Ansicht:
![image](https://user-images.githubusercontent.com/11231051/153259416-2b4a007b-7439-41a7-8956-1c5b066b6087.png)


## Während der Erstellung des Projektes sind diverse Quellen angezapft worden
Ein herzliches Danke deshalb an:

//db-class
https://github.com/kolodny/Db.class.php

//js table sort by name
https://www.w3schools.com/howto/howto_js_filter_table.asp

//make table sortierbar
https://www.j-berkemeier.de/TableSort.html

//glowing input field
https://www.w3docs.com/snippets/css/how-to-create-a-glowing-border-around-an-input-field.html

//toggle switch
https://www.w3schools.com/howto/howto_css_switch.asp

//snackbar
https://www.w3schools.com/howto/howto_js_snackbar.asp
