# Video-Lib
A little Overview of your Movies and Series

<img width="1119" height="990" alt="Demo" src="https://github.com/user-attachments/assets/d03905de-7042-4903-bbe6-ba75c6ebff32" />



Diese kleine php Datei ist für nutzer die einen kleinen Webserver mit heimischen Filmsammlungen
einer Oberfläche, ohne großen aufwand zu nutzen möchten. Orientiert wird sich in der entwicklung an KODI, NETFLIX und AMAZONE uvm. oder andere Film Anbieter.
Aber OHNE Teures Abbo!  Die Heimische Sammlung einfach anzeigen lassen und glücklich, werbefrei und schnell Loslegen.

Die $GLOBALS im Script mit den richtigen Pfaden und Addressen sowie Namen füllen und LOS!



Hier  Tragen Sie die Überschrift Ihrer Bibliothek ein! Bei SonderZeichen wie dem einfachen Anführungszeichen einen Backslash \ davor.

$GLOBALS['header']='Deine Video Bibliothek';



Geben Sie Hier bitte Ihre Main addresse an z.B. MeineDomain.org

$GLOBALS['main_server']='https://DeineDomain.ORG';


Geben Sie Hier bitte den relativen Filme-Pfad an
# !!! WICHTIG!!! 
Die Filme werden über ein bild .jpg oder .png erkannt d.h. Die filme sollten in
einzelnen ordnern Liegen und mit einem Titelbild versehen sein beispiel inhalt:
BASISORDNER

  |

  |--> Erster film ORDNER
 
  |  ----> FILM.JPG / FILM.PNG
 
  |  ----> FILM,MP4 ö.ä.
 
  |
 
  |-->Zweiter FilmOrdner
 
  |  ----> FILM.JPG / FILM.PNG
 
  |  ----> FILM.AVI
  

$GLOBALS['main_video_dir']='./FILE/DEINE-SPIELFILME';


Geben Sie hier den Pfad der NFO-xml an !!!

$GLOBALS['info']='_nfo/';

# ToDo

- Oberflächen konfigurator
- Spielfilme und Serien Auswahl
- Ausführliche nfo ausgabe
- ReDesign
- TMDB und IMDB API einbauen
- andere ADDON
