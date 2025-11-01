<?php
/*
Diese php ist für den Privaten Gebrauch Damit ein potentes Film und Serien Bibliothek auch ohne Media server oder ähnlicher

Software wie Kodi bestehen kann.

Copyright Michael Herholt ALIAS DO2ITH 08/ 2025
*/
session_start();
//Hier  Tragen Sie die Überschrift Ihrer Bibliothek ein! Bei SonderZeichen wie dem einfachen Anführungszeichen einen Backslash "\" davor.
$GLOBALS['header']='Deine Videothek';
// Geben Sie Hier bitte Ihre Main addresse an z.B. MeineDomain.org
$GLOBALS['main_server']='https://DeineDomain.org';
// Geben Sie Hier bitte den relativen Filme Pfad an
$GLOBALS['main_video_dir']='./Dein/FILME/Ordner';
// Geben Sie Hier bitte den relativen Serien Pfad an
$GLOBALS['main_serien_dir']='./Deine/Serien/Ordner';
// Geben Sie hier den Pfad der NFO-xml an !!!
$GLOBALS['info']='_nfo/';
// Was soll im Bideo Vorab Geladen werden ? none == Nichts, metadata == nur Meta Daten, auto == Automatische auswahl (Standart)
$GLOBALS['v_preload'] = 'auto';
// Video Automatisch abspieln ? (Yes // NO ) (No standart)
$GLOBALS['autoplay'] = 'no';

// Ab Hier KEINE Eintäge mehr Ändern!!!!!
$GLOBALS['reihe']=1;
$GLOBALS['s_reihe']=1;
$GLOBALS['vid']=0;
$GLOBALS['sid']=0;

// Ausgabe und abfrage der Verschiedenen oder einzelnen Filme
function sh_movie(){
		if(filter_input(INPUT_GET, 'movie')==1){
			$name = str_replace('.jpg', '', filter_input(INPUT_GET,'thumb'));
			$endung = pathinfo(filter_input(INPUT_GET,'thumb'));
			$dateiendung = $endung['extension'];
			if($dateiendung == 'jpg'){
				$nfo = str_replace('jpg', 'nfo', filter_input(INPUT_GET,'thumb'));
			}elseif($dateiendung == 'png'){
				$nfo = str_replace('png', 'nfo', filter_input(INPUT_GET,'thumb'));
			}
			$hedder = str_replace('.jpg','',filter_input(INPUT_GET,'thumb'));
			echo "<h1>".htmlspecialchars($hedder)."</h1>";
			echo "<div class='container'>";
					echo "<div class='detail'>";
						select_movie(filter_input(INPUT_GET,'dir'));
					echo "</div>";
					echo "<div class='detail'>";
						xml_out($nfo);
					echo "</div>";
					echo "<div class='detail'><img src='".$_SESSION['movid'.filter_input(INPUT_GET, 'dir')]."' height='360px' width='280px' alt='".$name."'title='".$name."'></div>";
					echo "<div class='clear'></div>";
				echo "</div>";
		}elseif(filter_input(INPUT_GET, 'movie')==2){
			play_movie(filter_input(INPUT_GET, 'dir'),filter_input(INPUT_GET, 'type'));
		}else{
		echo "<h1>".$GLOBALS['header']."</h1>";
		echo "<h2>S p i e l f i l m e</h2>";
		echo "<a href='javascript:history.back()' class='button'>Zurück</a><br>";
		echo "<p>&nbsp;</p>";
					list_dir_reku($GLOBALS['main_video_dir']); // Startet die rekursive Liste ab dem aktuellen Verzeichnis
					if ($GLOBALS['reihe'] != 1){
						echo "<div class='clear'></div></div>";
					}
					echo "<br><div class='clear'></div><p>Es sind insgesammt ".$GLOBALS['vid']." in der Bibliothek!</p>";
		}
}
// Ausgabe der Serie(n) 
function sh_serie(){
	echo "<h1>".$GLOBALS['header']."</h1>";
	echo "<h2>S e r i e n</h2>";
	echo "<a href='javascript:history.back()' class='button'>Zurück</a><br>";
	if(filter_input(INPUT_GET, 'serie')==1){
		select_serie(filter_input(INPUT_GET,'dir'),filter_input(INPUT_GET,'thumb'));
	}elseif(filter_input(INPUT_GET, 'serie')==2){
		play_staffel(filter_input(INPUT_GET, 'dir'), filter_input(INPUT_GET, 'st'));
	}else{
		serie_list($GLOBALS['main_serien_dir']);
	}
}
function play_staffel($dir, $st){
	echo "<h1>".str_replace('.jpg', '', filter_input(INPUT_GET,'thumb'))."</h1>";
	if ($st == 'all'){
		s_reku($_SESSION['sid'.$dir]);
	}
	else{
		$pa = str_replace(filter_input(INPUT_GET,'thumb'), '',$_SESSION['sid'.$dir].$st);
		s_reku($pa);
	}
}
function s_reku($dir){
	$pre_dir=pathinfo($dir);
	$sta_ar = scandir($pre_dir['dirname']);
	$video_array = array();
	if ($sta_ar !== false){
		foreach($sta_ar as $staffel_array){
			if($staffel_array != '.'&& $staffel_array != '..' && $staffel_array != '../'){
				$nxt_st = $pre_dir['dirname']."/".$staffel_array;
				if(is_dir($nxt_st)){
					$pre_folge = scandir($nxt_st);
					if($pre_folge !== false){
						foreach($pre_folge as $folge){
							$folge_pre_end = pathinfo($folge);
							$folge_end = $folge_pre_end['extension'];
							if($folge != '.' && $folge != '..' && $folge != '../' && $folge_end != 'jpg' && $folge_end != 'png' && filter_input(INPUT_GET,'st') == 'all'){
								$video_array[] = $GLOBALS['main_server']."/".$nxt_st."/".$folge;
							}elseif($folge != '.' && $folge != '..' && $folge != '../' && $folge_end != 'jpg' && $folge_end != 'png' && str_contains($nxt_st, filter_input(INPUT_GET, 'st'))){
								$video_array[] = $GLOBALS['main_server']."/".$nxt_st."/".$folge;
							}
						}
					}
				}elseif(is_file($nxt_st)){
					// Bereich für einen anderen Ansatz
				}
			}
		}
	}
	$json_videos = json_encode($video_array);
	echo "<div class='playlist-container'>";
	echo "<video id='videoPlayer' preload='".$GLOBALS['v_preload']."' controls autoplay width='640' height='360'>";
	echo "Ihr Browser unterstützt das Video-Tag nicht.";
	echo "</video>";
	echo "<ul id='playlist'>";
	foreach($video_array as $index => $path) {
		$filename = basename($path);
		$pre_img = $_SESSION['sid'.filter_input(INPUT_GET,'dir')];
		$post_img = rawurlencode($pre_img);
		$img = str_replace('%2F','/',$post_img);
		echo "<li data-src='".htmlspecialchars($path)."' data-index='".$index."'><img src='".$img."' style='width: 70px; height: 65px; float: left;' /><p style='float:left; margin-left:10px;'>".wordwrap(htmlspecialchars($filename),12,'<br>',true)."</p><p style='clear:both;'></p></li>";
	}
	echo "</ul>";
	echo "</div>";
	echo "<script>";
	echo "const videoPaths = ".$json_videos.";"; 
	echo "</script>";
	echo "<script src='playlist.js'></script>";
	unset($video_array);
}
function select_serie($dir,$thumb){
	$pre_dir = $_SESSION['sid'.$dir];
	$dir_post = str_replace($thumb, '', $pre_dir);
	$st_dir = scandir($dir_post);
	$name = str_replace('.jpg', '', filter_input(INPUT_GET,'thumb'));
	$hedder = str_replace('.jpg','',filter_input(INPUT_GET,'thumb'));
	echo "<h1>".htmlspecialchars($hedder)."</h1>";
	
	echo "<div class='container'>";
			echo "<div class='detail'>";
	echo "<a href='?choose=serie&serie=2&dir=".filter_input(INPUT_GET, 'dir')."&thumb=".filter_input(INPUT_GET,'thumb')."&st=all' class='button'>Alle Staffeln</a><br>";
	foreach($st_dir as $staffel_list){
		if(is_dir($dir_post.'/'.$staffel_list) && $staffel_list != '.' && $staffel_list != '..' && $staffel_list != '../'){
			echo "<a href='?choose=serie&serie=2&dir=".filter_input(INPUT_GET, 'dir')."&thumb=".filter_input(INPUT_GET,'thumb')."&st=".rawurlencode($staffel_list)."' class='button'>".$staffel_list."</a><br>";
		}
	}
			echo "</div>";
			echo "<div class='detail'><img src='".$_SESSION['sid'.filter_input(INPUT_GET, 'dir')]."' height='360px' width='280px' alt='".$name."'title='".$name."'></div>";
			echo "<div class='clear'></div>";
			echo "</div>";
}
// Serien Liste
function serie_list($dir){
	$list = scandir($dir);
	if($list !== false){
		foreach ($list as $liste){
			if($liste != '.' && $liste != '..' && $liste != '../' ){
				$pre_full_path = $dir . '/' . $liste;
				$full_path = str_replace('./','',$pre_full_path);
				if(is_dir($full_path)){
					serie_list($full_path);
				}elseif (is_file($full_path)){
					$pre_pic = pathinfo($full_path);
					$pic = $pre_pic['extension'];
					if($pic == 'jpg' || $pic == 'png'){
						$title = $pre_pic['filename'];
						if($GLOBALS['s_reihe']==1){
							$sid = $GLOBALS['sid'];
							$link = urldecode("?choose=serie&serie=1&dir=".$sid."&thumb=").rawurlencode($liste);
							echo "<div class='container'><a href='".$link."'><div class='image' ";
							btv($title);
							echo " ><img src='".str_replace('%2F','/',rawurlencode($full_path))."' height='260px' width='180px' alt='".$title." title='".$title."'><br>".wordwrap($title, 12, '<br>', true)."<br></div></a>";
							$_SESSION['sid'.$sid]=$full_path;
							$GLOBALS['s_reihe']++;
							$GLOBALS['sid']++;
						}elseif($GLOBALS['s_reihe']!=1 && $GLOBALS['s_reihe']<=4){
							$sid = $GLOBALS['sid'];
							$link = urldecode("?choose=serie&serie=1&dir=".$sid."&thumb=").rawurlencode($liste);
							echo "<a href='".$link."'><div class='image' ";
							btv($title);
							echo " ><img src='".str_replace('%2F','/',rawurlencode($full_path))."' height='260px' width='180px' alt='".$title." title='".$title."'><br>".wordwrap($title, 12, '<br>', true)."<br></div></a>";
							$_SESSION['sid'.$sid]=$full_path;
							$GLOBALS['s_reihe']++;
							$GLOBALS['sid']++;
						}else{
							$sid = $GLOBALS['sid'];
							$link = urldecode("?choose=serie&serie=1&dir=".$sid."&thumb=").rawurlencode($liste);
							echo "<a href='".$link."'><div class='image' ";
							btv($title);
							echo " ><img src='".str_replace('%2F','/',rawurlencode($full_path))."' height='260px' width='180px' alt='".$title." title='".$title."'><br>".wordwrap($title, 12, '<br>', true)."</div></a><div class='clear'></div></div>";
							$_SESSION['sid'.$sid]=$full_path;
							$GLOBALS['s_reihe'] = 1;
							$GLOBALS['sid']++;
						}
					}
				}
			}
		}
	}else{
		echo 'Oh was ist das ? Leider Keine Serie Gefunden!';
	}
	return $_SESSION;
}
function choose($choos){
	if ($choos=='movie'){
		sh_movie();
	}elseif($choos=='serie'){
		sh_serie();
	}else{
		echo "<h1>".$GLOBALS['header']."</h1>";
		echo "<h2>Was darf es sein?</h2>";
		echo "<a href='?choose=movie'><div class='choose' style='background-image: url(\"css/movie.jpg\");'><p></p></div></a>";
		echo "<a href='?choose=serie'><div class='choose' style='background-image: url(\"css/serie_3.jpg\");'><p></p></div></a>";
		echo "<div class='clear'></div>";
	}
}
function play_movie($dir, $type){
	if ($GLOBALS['autoplay']=='yes' || $GLOBALS['autoplay']== 'Yes') {
		$autoplay = 'autoplay';
	}else{
		$autoplay = '';
	}
	$link_type = $type;
	if ($type == 'm4v'){
		$type = 'mp4';
	}
	$poster = str_replace('%2F','/',rawurlencode($_SESSION['movid'.$dir]));
	$link = $GLOBALS['main_server'].'/'.str_replace('jpg',$link_type,$poster);
	$pre_titel = pathinfo($link);
	$titel = $pre_titel['filename'];
	echo "<h1>".urldecode($titel)."</h1>";
	echo "<a href='javascript:history.back()' class='button'>Zurück</a><br>";
	echo "<video controls preload='".$GLOBALS['v_preload']."' ".$autoplay."  width='1024px' height='768px' poster='".$poster."'>";
	echo "<source src='".$link."' type='video/".$type."'>";
	echo "Your browser does not support the video tag.";
	echo "</video>";
}
function btv($text){
	$langer = mb_strlen($text);
	$nsize = '';
	if ($langer <= 40 && $langer > 20){
		$nsize = "style='font-size: 16pt;'";
	}elseif($langer >= 41 && $langer <= 50 ){
		$nsize = "style='font-size: 14pt;'";
	}elseif($langer >= 51 ){
                 $nsize = "style='font-size: 12pt;'";
	}else{
		$nsize = '';
	}
	echo $nsize;
}
function xml_out($nfo){
	global $GLOBALS;
	$filePath = $GLOBALS['info'].$nfo;
	// Lade die XML-Datei
	$xml = simplexml_load_file($filePath, 'SimpleXMLElement', LIBXML_NONET | LIBXML_NOENT);
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
	$tmpII = str_replace(filter_input(INPUT_GET,'thumb'),"",$tmp);
	$mov_dir = scandir($tmpII);
	echo "<a href='javascript:history.back()' class='button'>Zurück</a><br>";
	$video_erweiterungen = array('mp4', 'mkv', 'avi', 'mov', 'webm', 'm4v','flv');
	for ($i = 0; $i < count($mov_dir); $i++){
		if($mov_dir[$i] != "." && $mov_dir[$i] != ".." && $mov_dir[$i] != "../"){
			$link = '';
			$dateinformationen = pathinfo($mov_dir[$i]);
			$dateiendung_lower = strtolower($dateinformationen['extension']);
			$dateiendung = $dateinformationen['extension'];
				if(in_array($dateiendung_lower, $video_erweiterungen)){
					$link = "?choose=movie&movie=2&dir=".$pfad."&type=".$dateiendung;
					echo "<a href='".$link."' class='play'>".$mov_dir[$i]."</a><br>";
				}
		}
	}
}
function list_dir_reku($verzeichnis) {
	$eintraege = scandir($verzeichnis);
	if ($eintraege !== false) {
		foreach ($eintraege as $eintrag) {
			if ($eintrag != "." && $eintrag != ".." && $eintrag != "../") {
				$vollstaendiger_pfad = $verzeichnis . '/' . $eintrag;
				if (is_dir($vollstaendiger_pfad)) {
					// Rekursiver Aufruf für Unterverzeichnisse
					list_dir_reku($vollstaendiger_pfad);
				} elseif (is_file($vollstaendiger_pfad)) {
					$bi = str_replace("./", "", $vollstaendiger_pfad);
					$dateinformationen = pathinfo($bi);
					$dateiendung = $dateinformationen['extension'];
					$title = str_replace(".".$dateiendung, "", $eintrag);
					// Diese Zeile ist Obsolet ? $dir = str_replace("./", "", $verzeichnis);
					if ($dateiendung == "jpg" || $dateiendung == "png"){
						if ($GLOBALS['reihe']==1){
							$movid=$GLOBALS['vid'];
							$link = urldecode("?choose=movie&movie=1&dir=".$movid."&thumb=").rawurlencode($eintrag);
							echo "<div class='container'><a href='".$link."'><div class='image' ";
							btv($title);
							echo " ><img src='".str_replace('%2F','/',rawurlencode($bi))."' height='260px' width='180px' alt='".$title." title='".$title."'><br>".wordwrap($title, 12, '<br>', true)."<br></div></a>";
							$_SESSION['movid'.$movid]=$bi;
							$GLOBALS['reihe']++;
							$GLOBALS['vid']++;
						}elseif($GLOBALS['reihe']!=1 && $GLOBALS['reihe']<=4){
							$movid=$GLOBALS['vid'];
							$link = urldecode("?choose=movie&movie=1&dir=".$movid."&thumb=").rawurlencode($eintrag);
							echo "<a href='".$link."'><div class='image' ";
							btv($title);
							echo " ><img src='".str_replace('%2F','/',rawurlencode($bi))."' height='260px' width='180px' alt='".$title." title='".$title."'><br>".wordwrap($title, 12, '<br>', true)."<br></div></a>";
							$_SESSION['movid'.$movid]=$bi;
							$GLOBALS['reihe']++;
							$GLOBALS['vid']++;
						}else{
							$movid=$GLOBALS['vid'];
							$link = urldecode("?choose=movie&movie=1&dir=".$movid."&thumb=").rawurlencode($eintrag);
							echo "<a href='".$link."'><div class='image' ";
							btv($title);
							echo " ><img src='".str_replace('%2F','/',rawurlencode($bi))."' height='260px' width='180px' alt='".$title." title='".$title."'><br>".wordwrap($title, 12, '<br>', true)."</div></a><div class='clear'></div></div>";
							$_SESSION['movid'.$movid]=$bi;
							$GLOBALS['reihe'] = 1;
							$GLOBALS['vid']++;
						}
					}else{
						// Bereich für mehr
					}
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
		<title><?php echo $GLOBALS['header']; ?></title>
	</head>
	<body>
		<div id=main>
<?php
choose(filter_input(INPUT_GET,'choose'));
?>
		</div>
	</body>
</html>
