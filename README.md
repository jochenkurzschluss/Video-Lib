# Video-Lib
A little Overview of your Movies and Series


![Uploading Demo.png…]()

Diese kleine php Datei ist für nutzer die einen kleinen webserver mit heimischen Filmsammlungen
einer oberfläche, ohne großen aufwand zu nutzen Möchten. Orientiert wird sich n der entwicklung an KODI, NETFLIX und AMAZONE uvm. der Film anbieter.
Aber OHNE Teures Abbo!  Die Heimische Sammlung einfach anzeigen lassen und glücklich, werbefrei und schnell Loslegen.

Die $GLOBALS im Script mit den richtigen Pfaden und Addressen sowie Namen füllen und LOS!



Hier  Tragen Sie die Überschrift Ihrer Bibliothek ein! Bei SonderZeichen wie dem einfachen Anführungszeichen einen Backslash "\" davor.

$GLOBALS['header']='Deine Video Bibliothek';



Geben Sie Hier bitte Ihre Main addresse an z.B. MeineDomain.org

$GLOBALS['main_server']='https://DeineDomain.ORG';


Geben Sie Hier bitte den relativen Filme Pfad an
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
