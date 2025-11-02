README.md

Your Readme is Done 🎉🎉🎉
Star This Project
Fork on Github

<h1 align="center">Video-Lib Deine Private Videothek</h1>

###

<div align="center">
  <img height="400" src="https://github.com/user-attachments/assets/d03905de-7042-4903-bbe6-ba75c6ebff32"  />
</div>

###

<p align="left">Diese kleine php Datei ist für nutzer die einen kleinen Webserver mit der heimischen Filmsammlung einer Oberfläche, ohne großen aufwand zu nutzen können. Orientiert wird sich in der entwicklung an KODI, NETFLIX und AMAZONE uvm. oder andere Film Anbieter. Aber OHNE Teures Abbo! Die Heimische Sammlung einfach anzeigen lassen und glücklich, werbefrei und schnell Loslegen.<br><br>Die $GLOBALS im Script mit den richtigen Pfaden und Addressen sowie Namen füllen und LOS!<br><br>Hier Tragen Sie die Überschrift Ihrer Bibliothek ein! Bei SonderZeichen wie dem einfachen Anführungszeichen einen Backslash \ davor.<br><br>$GLOBALS['header']='Deine Video Bibliothek';<br><br>Geben Sie Hier bitte Ihre Main addresse an z.B. MeineDomain.org oder die IP-Addresse ein.<br><br>$GLOBALS['main_server']='https://DeineDomain.ORG';<br><br>Geben Sie Hier bitte den relativen Filme-Pfad an</p>

###

<h2 align="left">!!! WICHTIG!!!</h2>

###

<p align="left">Die Filme werden über ein Bild .jpg oder .png erkannt d.h. Die Filme sollten in einzelnen Ordnern liegen und mit einem Titelbild versehen sein beispiel inhalt: BASISORDNER</p>

###

<p align="left">|--> Erster film ORDNER<br><br>     | --|__> FILM.JPG / FILM.PNG<br><br>     | --__> FILM,MP4 ö.ä.<br><br>|-->Zweiter FilmOrdner<br><br>     | --|__> FILM.JPG / FILM.PNG<br><br>     | --|__> FILM.AVI</p>

###

<p align="left">$GLOBALS['main_video_dir']='./FILE/DEINE-SPIELFILME';<br><br>Geben Sie hier den Pfad der NFO-xml an !!!<br><br>$GLOBALS['info']='_nfo/';</p>

###

<h2 align="left">ToDo</h2>

###

<p align="left">[] Oberflächen konfigurator<br>[*] Spielfilme und Serien Auswahl (Erledigt)<br>[] Ausführliche nfo ausgabe<br>[] ReDesign (begonnen)<br>[] TMDB und IMDB API einbauen<br>[] andere ADDON</p>

###
