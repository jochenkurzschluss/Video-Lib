<?php
/*
Diese php ist für den Privaten Gebrauch Damit ein potentes Film und Serien Bibliothek auch ohne Media server oder ähnlicher
Software wie Kodi bestehen kann.

Copyright Michael Herholt ALIAS DO2ITH 08/ 2025
*/
session_start();
//Hier  Tragen Sie die Überschrift Ihrer Bibliothek ein! Bei SonderZeichen wie dem einfachen Anführungszeichen einen Backslash "\" davor.
$GLOBALS['header']='Deine Video Bibliothek';
// Geben Sie Hier bitte Ihre Main addresse an z.B. MeineDomain.org
$GLOBALS['main_server']='https://DeineDomain.ORG';
// Geben Sie Hier bitte den relativen Filme Pfad an
$GLOBALS['main_video_dir']='./FILE/DEINE-SPIELFILME';
// Geben Sie hier den Pfad der NFO-xml an !!!
$GLOBALS['info']='_nfo/';



// Ab Hier KEINE Eintäge mehr Ändern!!!!!
$GLOBALS['reihe']=1;
$GLOBALS['vid']=1;


function play_movie($dir, $type){
	$movii = str_replace('./', '/',$_SESSION['movid'.$dir]);
	$mov = str_replace(' ', '%20',$movii);
	$movie = str_replace('jpg',$type,$mov);
	// Debug der Varriabel(n)
	if ($type == 'm4v'){
		$type = 'mp4';
	}
	echo "<h1>Hier dein Video</h1>";
	echo "<a href='javascript:history.back()' class='button'>Zurück</a><br>";
	echo "<video controls preload='none' width='1024px' height='768px' poster='".$_SESSION['movid'.$dir]."'>";
	echo "<source src='".$GLOBALS['main_server']."/".$movie."' type='video/".$type."'>";
	echo "Your browser does not support the video tag.";
	echo "</video>";
}

function btv($text){
	if (mb_strlen($text)>=60){
		$nsize = "style='font-size: 12pt;'";
	}
	elseif (mb_strlen($text)>=40 && mb_strlen($text)<=50){
		$nsize = "style='font-size: 15pt;'";
	}
	return $nsize;
}

function xml_out($nfo){
	$filePath = $GLOBALS['info'].$nfo;
	// Lade die XML-Datei
	$xml = simplexml_load_file($filePath);
	// Überprüfe, ob das Laden erfolgreich war
	if ($xml === false) {
		echo "Fehler beim Laden der XML-Datei.";
	} else {
		// Gib den Inhalt des 'plot'-Elements aus
		$plot = (string) $xml->plot;
		echo $plot; // augabe
	}
}
function select_movie($pfad){
	$tmp = $_SESSION['movid'.$pfad];
	$tmpII = str_replace($_GET['thumb'],"",$tmp);
	$mov_dir = scandir($tmpII);
	echo "<a href='javascript:history.back()' class='button'>Zurück</a><br>";
	$video_erweiterungen = array('mp4', 'mkv', 'avi', 'mov', 'webm', 'm4v','flv');
	for ($i = 0; $i < count($mov_dir); $i++){
		if($mov_dir[$i] != "." && $mov_dir[$i] != ".." && $mov_dir[$i] != "../"){
			$dateinformationen = pathinfo($mov_dir[$i]);
			$dateiendung_lower = strtolower($dateinformationen['extension']);
			$dateiendung = $dateinformationen['extension'];
				if(in_array($dateiendung_lower, $video_erweiterungen)){
					echo "<a href='?movie=2&dir=".$pfad."&type=".$dateiendung."' class='play'>".$mov_dir[$i]."</a><br>";
				}
		}
	}
}

function liste_verzeichnis_rekursiv($verzeichnis) {
	//$reihe = 1;
	$eintraege = scandir($verzeichnis);
	if ($eintraege !== false) {
		foreach ($eintraege as $eintrag) {
			if ($eintrag != "." && $eintrag != ".." && $eintrag != "../") {
				$vollstaendiger_pfad = $verzeichnis . '/' . $eintrag;
				if (is_dir($vollstaendiger_pfad)) {
					//echo "Verzeichnis: " . $vollstaendiger_pfad . "<br>";
					// Rekursiver Aufruf für Unterverzeichnisse
					liste_verzeichnis_rekursiv($vollstaendiger_pfad);
				} elseif (is_file($vollstaendiger_pfad)) {
					$bi = str_replace("./", "", $vollstaendiger_pfad);
					$dateinformationen = pathinfo($bi);
					$dateiendung = $dateinformationen['extension'];
					$title = str_replace(".".$dateiendung, "", $eintrag);
					$dir = str_replace("./", "", $verzeichnis);
					if ($dateiendung == "jpg" || $dateiendung == "png"){
						if ($GLOBALS['reihe']==1){
							$movid=$GLOBALS['vid'];
							echo "<div class='container'><a href='?movie=1&dir=".$movid."&thumb=".$eintrag."'><div class='image' ".btv($title)."  ><img src='".$bi."' height='260px' width='180px' alt='".$title." title='".$title."'><br>".wordwrap($title, 12, '<br>', true)."<br></div></a>";
							$_SESSION['movid'.$movid]=$bi;
							$GLOBALS['reihe']++;
							$GLOBALS['vid']++;
						}elseif($GLOBALS['reihe']!=1 && $GLOBALS['reihe']<=4){
							$movid=$GLOBALS['vid'];
							echo "<a href='?movie=1&dir=".$movid."&thumb=".$eintrag."'><div class='image' ".btv($title)."  ><img src='".$bi."' height='260px' width='180px' alt='".$title." title='".$title."'><br>".wordwrap($title, 12, '<br>', true)."<br></div></a>";
							$_SESSION['movid'.$movid]=$bi;
							$GLOBALS['reihe']++;
							$GLOBALS['vid']++;
						}else{
							$movid=$GLOBALS['vid'];
							echo "<a href='?movie=1&dir=".$movid."&thumb=".$eintrag."'><div class='image' ".btv($title)." ><img src='".$bi."' height='260px' width='180px' alt='".$title." title='".$title."'><br>".wordwrap($title, 12, '<br>', true)."</div></a><div class='clear'></div></div>";
							$_SESSION['movid'.$movid]=$bi;
							$GLOBALS['reihe'] = 1;
							$GLOBALS['vid']++;
						}
					}else{
					//echo $bi."leider nein ---><br>";
					}
					//echo "Datei: " . $vollstaendiger_pfad . "<br>";
				}
			}
		}
	} else {
		echo "<p>Fehler beim Lesen des Verzeichnisses: " . $verzeichnis . "</p>";
	}
	return $_SESSION;
}
?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<meta name="author" content= "Michael Herholt">
		<meta name="publisher" content= "Michael Herholt">
		<meta name="copyright" content= "Michael Herholt">
		<meta name="page-type" content= "Private Homepage">
		<meta name="page-topic" content= "Private Homepage">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="css/favicon.ico" sizes="48x48">
		<link rel="stylesheet" href="css/style.css">
		<title>Video-Bibliothek</title>
	</head>
	<body>
		<div id=main>
<?php
if($_GET['movie']==1){
	$name = str_replace('.jpg', '', $_GET['thumb']);
	$endung = pathinfo($_GET['thumb']);
	$dateiendung = $endung['extension'];
	if($dateiendung == 'jpg'){
		$nfo = str_replace('jpg', 'nfo', $_GET['thumb']);
	}elseif($dateiendung == 'png'){
		$nfo = str_replace('png', 'nfo', $_GET['thumb']);
	}
	echo "<h1>".str_replace('.jpg','',$_GET['thumb'])."</h1>";
	echo "<div class='container'>";
			echo "<div class='detail'>";
				select_movie($_GET['dir']);
			echo "</div>";
			echo "<div class='detail'>";
			//$NFO = str_replace("/","",$nfo);
				xml_out($nfo);
			echo "</div>";
			echo "<div class='detail'><img src='".$_SESSION['movid'.$_GET['dir']]."' height='360px' width='280px' alt='".$name."'title='".$name."'></div>";
			echo "<div class='clear'></div>";
		echo "</div>";
}elseif($_GET['movie']==2){
	play_movie($_GET['dir'],$_GET['type']);
}else{
echo "<h1>".$GLOBALS['header']."</h1>";
echo "<p>Hier die Viedeos die zur Verfügung stehen</p>";
			liste_verzeichnis_rekursiv($GLOBALS['main_video_dir']); // Startet die rekursive Liste ab dem aktuellen Verzeichnis
			if ($GLOBALS['reihe'] != 1){
				echo "<div class='clear'></div></div>";
			}
			echo "<br><div class='clear'></div><p>Es sind insgesammt ".$GLOBALS['vid']." in der Bibliothek!</p>";
}


?>
		</div>
	</body>
</html>
