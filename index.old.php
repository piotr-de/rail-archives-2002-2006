<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<?
//	  	  	   		  			   			 				   					VARIABLES
include('source/counter.php');
$address=strval($_SERVER['REMOTE_ADDR']);
$votedate=date("m.Y",time());
$voteipfile='/home/piotrd/logs/voting-ip-'.$votedate.'.txt';
$votefile='/home/piotrd/logs/voting-'.$votedate.'.txt';
//													   						COUNT_LINES
function count_lines($file_to_count) {
if (file_exists($file_to_count)) {
$count_file=file($file_to_count);
$lines=count($count_file);
return $lines;
} else {
return 'Err!';
}
}
// 	  	  	   		  			   			 				   GETDESC
function getdesc ($category,$name) {
$lines=file($category.'/'.$name.'.txt');
return $lines[0];
}
// 	   			 											   PUB
function pub($dir,$ext,$order,$type) {
echo('<p style="margin: 10px;">');
$handle=opendir($dir);
$items=array();
while ($pubfile = readdir($handle)) {
if (!(preg_match("/\.+\.$/",$pubfile)) && preg_match("/\w+\.$ext/",$pubfile)) {
array_push($items,$pubfile);
} 
}
if ($order=="r") {
rsort($items);
} else {
sort($items);
}
closedir($handle);
$i=1;
foreach ($items as $file) {
$size=filesize($dir.'/'.$file)/1000;
if (date("m.Y",filemtime($dir.'/'.$file))==date("m.Y",time())) {
$colour='red';
} else {
$colour='#336699';
}
$isize=getimagesize($dir.'/'.$file);
if ($type=="img" && is_file($dir.'/small/'.$file)) {
$imgsize=getimagesize($dir.'/small/'.$file);
$image='<img src="'.$dir.'/small/'.$file.'" border="0" '.imgsize($dir.'/small/'.$file,"wh").'alt="'.$file.' ['.$size.' KB]">';
$output='<a href="javascript:photo(\''.$dir.'/'.$file.'\',\''.$isize[0].'\',\''.$isize[1].'\',\''.$file.'\')" style="color: '.$colour.';">'.$image.'</a>&nbsp;&nbsp;';
if (is_int($i/3)) {
$output.='<br><br>';
}
} elseif ($type=="img") {
$output='<a href="javascript:photo(\''.$dir.'/'.$file.'\',\''.$isize[0].'\',\''.$isize[1].'\',\''.$file.'\')" style="color: '.$colour.';"><b>'.$file.'</b> ['.$size.' KB]</a><br>';
} else {
$output='<a href="'.$dir.'/'.$file.'"><b>'.$file.'</b> ['.$size.' KB]</a><br>';
}
echo ($output);
$i++;
}
echo ('</p>');
}
//	   			 											   FILE_COUNTER
function file_counter ($dir,$ext) {
$handle=opendir($dir);
	//$files=array();
	$files=0;
while (($file=readdir($handle)) !== false) { 
if (preg_match("/.+\.$ext/",$file)) { 
	//array_push ($files,$file);
	$files++;
} 
}
closedir($handle);
	//$filesnr=count($files);
	//return $filesnr;
	return $files;
}
//	   				   	  			  	   	 				   IMGSIZE
function imgsize($img,$param) {
$size=getimagesize($img);
if ($param=="w") {
return $size[0];
} elseif ($param=="h") {
return $size[1];
} elseif ($param=="wh") {
return $size[3];
}
}
//	   					 	   								   IMGSIZE end
//	   				   	  			  						   CONSTANTS
$javascript='<script language="javascript" src="js/photo.js" type="text/javascript"></script>';
if (isset($id)) {
if ($id=="newphotos") {
$meta='';
$title='Photographs of the current month';
} elseif ($id=="stats") {
$meta='';
$title='Statistics';
#} elseif ($id=="mov") {
#$meta='';
#$title='Movies';
} elseif ($id=="misc") {
$meta='';
$title='Photo miscellany';
} elseif ($id=="infr") {
$meta='';
$title='Infrastructure';
} elseif ($id=="voting") {
$meta='';
$title='The best photo voting';
} elseif ($id=="exif") {
$meta='';
$title='photo.info';
} elseif ($id=="tech") {
$meta='';
$title='Technical information';
}
//				 	   		   			  				   		  		  CONTENT
echo ($meta.'<META HTTP-EQUIV="content-type" CONTENT="text/html; CHARSET=iso-8859-2">
<link rel="StyleSheet" href="main.css" type="text/css">');
print $javascript;
echo('<title>Railways in Poland/'.$title.'</title>
</head>
<body>
<table border="0" align="center" class="main" cellpadding="1" cellspacing="1">
<tr>
<td class="tdmain" style="background-color: #FFFF80;">
<a href="index.php"><img src="img/logo.jpg" alt="Railways in Poland" width="400" height="100" border="0"></a>
</td>
</tr>
<tr>
<td class="tdmain" style="background-color: #0080c0;">
<a href="index.php" class="menu">/RiP/</a><span class="header">'.$title.'</span>
</td>
</tr>
<tr>
<td class="tdmain" style="background-color: #ffff80;">');
//		 			   	   		   		  		  	   				VOTING 		 			   	   		   		  		  	   								
if ($id=="voting" && isset($photo) && file_exists($photo)) {
$links='<a href="index.php"><img src="img/this2.gif" width="10" height="10" alt="&gt;" border="0" align="middle">Home</a><br>';
// IP check
$iphandle=fopen($voteipfile,"a+");
flock($iphandle,LOCK_EX);
if (!(file_exists($voteipfile))) {
fwrite($iphandle,$address."\n");
fclose($iphandle);
} elseif (file_exists($voteipfile)) {
$iplist=fread($iphandle,filesize($voteipfile));
$iplist=explode("\n",$iplist);
if (in_array($address,$iplist)) {
echo('<b>T</b>he vote from this IP address has already been registered. You can vote only once a month.<br><br>'.$links);
} else {
fwrite($iphandle,$address."\n");
if (file_exists($votefile)) {
$votehandle=fopen($votefile,"r+");
$votelist=file($votefile);
flock($votehandle,LOCK_EX);
foreach ($votelist as $voteitem) {
$voteitem=rtrim($voteitem);
$vote=explode("^",$voteitem);
if ($vote[0]==$photo) {
$found=1;
$nr=$vote[1]+1;
fwrite($votehandle,$vote[0]."^".$nr."\n");
} elseif ($vote[0]!=$photo) {
fwrite($votehandle,$vote[0]."^".$vote[1]."\n");
}
}
if (!(isset($found))) {
fwrite($votehandle,$photo."^1\n");
}
} elseif (!(file_exists($votefile))) {
$votehandle=fopen($votefile,"a");
flock($votehandle,LOCK_EX);
fwrite($votehandle,$photo."^1\n");
}
flock($votehandle,LOCK_UN);
fclose($votehandle);
echo('<b>T</b>he vote has been registered. Thank you.<br><br>'.$links);
}
}
flock($iphandle,LOCK_UN);
fclose($iphandle);
//										   		   					VOTING end
#} elseif ($id=="form") {
//		 			   									   FORM
#if (isset($form)!="post") {
#include('source/form.txt');
#} else {
#function getvars() {
#foreach ($_POST as $name => $value) {
#$vars.=$name.": ".$value."\n";
#}
#return $vars;
#}
#$message="Koleje w Polsce - ankieta:\n\n";
#$message.=getvars();
#$message.="\nPowered by PHP4. Copyright 2003 Piotr Damer [ http://railway.eu.org/ ]";
#$headers = "From: railway.eu.org Visitor <visitor@railway.eu.org>\nX-Mailer: PHP4";
#if ($_POST) {
#$sent=mail("piotrd@plo.lublin.pl","Koleje w Polsce - ankieta",$message,$headers);
#}
#if ($sent) {
#$msg='Ankieta zosta³a wys³ana. Dziêkujê.<br><span class="small">Your questionnaire was sent. Thank you.</span>';
#} else {
#$msg='Wyst±pi³ b³±d. Ankieta nie zosta³a wys³ana.<br><span class="small">The questionnaire was not sent due to an error. Sorry.</span>';
#}
#echo($msg.'<br><br><a href="index.php">Powrót do strony g³ównej <span class="small">(Back to the main page)</span></a>');
#}
//					  						  	 		FORM end
#} elseif ($id=="mov") {
//		 			   									FILMS
#pub('films','mpg','s','film');
#pub('films','mov','s','film');
//	 		  											FILMS end
} elseif ($id=="misc") {
//		 			   									MISC
echo('<p>[<a href="index.php?id=misc&dir=2000">2000</a>] | [<a href="index.php?id=misc&dir=2001">2001</a>] | [<a href="index.php?id=misc&dir=2002">2002</a>] | [<a href="index.php?id=misc&dir=2003">2003</a>] | [<a href="index.php?id=misc&dir=2004">2004</a>] | [<a href="index.php?id=misc&dir=2005">2005</a>]</p>');
$dir2=$id.'/'.$dir;
if (!($dir)) {
$dir='misc/'.date("Y",time());
pub($dir,'jpg','r','img');
} elseif (($dir2) && is_dir($dir2)) {
pub($dir2,'jpg','r','img');
}
//	 		  											MISC end
} elseif ($id=="infr") {
//		 			   									INFR
pub('infr','jpg','s','img');
//				   										INFR
} elseif ($id=="tech") {
//		 				   								TECH
#$space=disk_total_space('/home/piotrd/kwl')-disk_free_space('/home/piotrd/kwl');
#$space=$space/268435456;
function Du($dir)
{
       $du = popen("/usr/bin/du -sk $dir", "r");
       $res = fgets($du, 7);
       pclose($du);
       $res = explode(" ", $res);
       return $res[0];
}
$space=du('/home/piotrd/kwl');
$space=$space/1000;
$gal=opendir('gal');
$photo_nr=0;
while (($galdir=readdir($gal)) !== false) {
if (is_dir('gal/'.$galdir)) {
if ($galdir!="." && $galdir!=".." && $galdir!="source") {
$photo_nr+=file_counter('gal/'.$galdir,'jpg');
}
}
}
echo('<p>
<b>Server:&nbsp;</b>'.$_SERVER['SERVER_ADDR'].' '.gethostbyaddr($_SERVER['SERVER_ADDR']).'<br>
<b>Virtual host:&nbsp;</b>'.$_SERVER['SERVER_NAME'].'<br>
<b>PHP version:&nbsp;</b>'.phpversion().'<br>
<b>Server software:&nbsp;</b>'.$_SERVER['SERVER_SOFTWARE'].'<br>
<b>Disk space occupied:&nbsp;</b>'.$space.' MB<br>
<b>Railway Gallery (*.jpg):&nbsp;</b>'.$photo_nr.' photographs<br>
</p>');
//	   									 				TECH	   								
} elseif ($id=="exif" && file_exists($photo)) {
//		 			   									EXIF
$size=filesize($photo)/1000;
echo '<b>File:</b>&nbsp;'.$photo.'<br />
<b>Width:</b>&nbsp;'.imgsize($photo,'w').'&nbsp;px<br />
<b>Height:</b>&nbsp;'.imgsize($photo,'h').'&nbsp;px<br />
<b>Size:</b>&nbsp;'.$size.'&nbsp;KB<br>';
echo('<b>EXIF:</b><br />');
$exif = exif_read_data($photo,IFD0);
foreach($exif as $key=>$section) {
foreach($section as $name=>$val) {
echo "$key.$name: $val<br />\n";
}
} 
//				   										EXIF
} elseif ($id=="stats") {
// 		 				 								STATS
if (isset($month) && is_dir('/home/piotrd/logs/stats/'.$month)) {
$dirdate=$month;
} else {
$dirdate=date("m.Y");
}
if (!(is_dir('/home/piotrd/logs/stats/'.$dirdate))) {
mkdir("/home/piotrd/logs/stats/".$dirdate,0777);
}
$globaldirname='/home/piotrd/logs/stats/';
$dir=$globaldirname.$dirdate;
$logsdir=opendir($dir);
$days=array();
while (($logfile=readdir($logsdir)) !== false) {
if (preg_match("/^ip-.+".$dirdate."-am\.txt/",$logfile)) {
array_push($days,$logfile);
}
}
if (count($days)==0) {
echo('<p>No data</p>');
} elseif (count($days)!=0) {
$amfile='ip-'.$log.'-am.txt';
$pmfile='ip-'.$log.'-pm.txt';
if (isset($log) && file_exists($dir.'/'.$amfile)) {
$logfile_am_content=file($dir.'/'.$amfile);
if (file_exists($dir.'/'.$pmfile)) {
$logfile_pm_content=file($dir.'/'.$pmfile);
}
echo('Total number of visits: <a href="index.php?id=stats"><b>'.counter($address).'</b></a><br><br>
Visitors on <b>'.$log.'</b>:<br><br>');
$i=1;
foreach ($logfile_am_content as $logitem) {
echo('<b>'.$i.'.</b> '.$logitem.'<br>');
$i++;
}
if ($logfile_pm_content) {
foreach ($logfile_pm_content as $logitem) {
echo('<b>'.$i.'.</b> '.$logitem.'<br>');
$i++;
}
}
} else {
echo('Total visits amount since 11 January 2002: <b>'.counter($address).'</b><br><br>');
$globaldir=opendir($globaldirname);
$monthdirs=array();
while (($monthdir=readdir($globaldir)) !== false) {
if (is_dir($globaldirname.'/'.$monthdir) && preg_match("/^\d{2}\.\d{4}/",$monthdir) && $monthdir!=$dirdate) {
array_push($monthdirs,$monthdir);
}
}
sort($monthdirs);
foreach ($monthdirs as $monthdir) {
echo('<a href="?id=stats&month='.$monthdir.'">'.$monthdir.'</a><br>');
}
echo('<br>Visits in <b>'.$dirdate.':</b><br><br>');
sort($days);
$i_global=1;
foreach ($days as $day) {
$file_am=file($dir.'/'.$day);
$visitors_am=count($file_am);
$day=trim($day,"ip-");
$day=rtrim($day,".txt");
$day=explode("-",$day);
$day_pm='ip-'.$day[0].'-pm.txt';
$visitors=$visitors_am;
if (file_exists($dir.'/'.$day_pm)) {
$file_pm=file($dir.'/'.$day_pm);
$visitors_pm=count($file_pm);
$visitors=$visitors_am+$visitors_pm;
} else {
$visitors=$visitors_am;
}
$width=$visitors*2;
echo('<b>'.$day[0].':</b><br><table style="background-color: #ffff80; width: '.$width.' px;" border="0" cellpadding="2" cellspacing="2"><tr><td style="background-color: red; font: normal 7pt Tahoma; color: white; width: '.$width.' px;" width="'.$width.'"><a class="menu" href="?id=stats&month='.$dirdate.'&log='.$day[0].'">'.$visitors.'</a></td></tr></table><br>');
$i_global++;
$visitors_total=$visitors_total+$visitors;
}
echo('Total in '.$dirdate.': <b>'.$visitors_total.'</b>');
}
//					 									STATS end
}
} elseif ($id=="newphotos") {
//		 					 							NEWPHOTOS
echo('<b>H</b>ere you can see all the photographs published in the <a href="gal/gal.php">gallery</a> in <b>'.date("F Y",time()).'</b>:</span>');
$gal=opendir('gal');
while (($galdir=readdir($gal)) !== false) {
if (is_dir('gal/'.$galdir)) {
$dir=opendir('gal/'.$galdir);
$i=1;
$desc=strtr($galdir,"abcdefghijklmnopqrstuvwxyz","ABCDEFGHIJKLMNOPQRSTUVWXYZ");
if ($galdir!="." && $galdir!=".." && $galdir!="source") {
echo('<br><br><div class="menu2" style="width: 50%;">'.$desc.'</div><br>');
}
while (($file=readdir($dir)) !== false) {
$location='gal/'.$galdir.'/'.$file;
$locationsmall='gal/'.$galdir.'/small/'.$file;
if (!($date)) {
$date=date("nY",time());
}
if (preg_match("/\w+\.jpg/",$file) && date("nY",filemtime($location))==$date) {
$name=$desc;
$name_beta=rtrim($file,"/\.jpg/");
if ($name_beta!=$galdir) {
$name.='-';
$name.=rtrim($file,"/\.jpg/");
}
echo('<a href="javascript:photo(\'gal/'.$galdir.'/'.$file.'\',\''.imgsize($location,"w").'\',\''.imgsize($location,"h").'\',\''.$name.'\')"><img src="gal/'.$galdir.'/small/'.$file.'" alt="'.$name.'" border="0" width="'.imgsize($locationsmall,"w").'" height="'.imgsize($locationsmall,"h").'"></a>&nbsp;');
if (is_int($i/4)) {
echo('<br>');
}
$i++;
}
}
}
}
//														NEWPHOTOS end
} else {
echo ('<p><b>Error 404</b><br><a href="index.php"><img src="img/this2.gif" alt="&gt;" align="middle" border="0" width="10" height="10">Main page</a></p>');
}
echo ('<tr>
<td class="tdmain" style="background-color: #ddeeff;">
&copy; 2002-'.date("Y",time()).'&nbsp;railway.eu.org [<a href="?id=stats"><b>'.counter($address).'</b></a>]
</td>
</tr>
</table>');
} else {
echo ('<META NAME="keywords" CONTENT="polish railways trams buses trolleybuses Railways Poland, Europe, koleje w Polsce PL, transport w Polsce, Railways in europe, eastern europe, Polska, Polsko, Czech, Germany, Austria, Slovakia, Ukraine, Polska kolej, pkp, Lublin, railways, film, Poland, railroad, locomotives, engine, depot, station, tracks, bahnhof, koleje w Polsce, poci±gi, kolejnictwo, tory, zwrotnica, szyna, trakcja, bahn, railways, rolling stock, lokomotywa towarowa, DB, MAV, eisenbahn, urban transport">
<META NAME="description" CONTENT="Railways in Poland & Europe">
<META http-equiv="author" content="Peter / Piotr Damer">
<META HTTP-EQUIV="content-type" CONTENT="text/html; CHARSET=iso-8859-2">
<script language="JavaScript" type="text/javascript" src="js/photo.js"></script>
<link rel="StyleSheet" type="text/css" href="main.css">
<title>Railways in Poland</title>
</head>
<body>
<!--MAINTABLE-->
<table border="0" align="center" class="main" cellpadding="1" cellspacing="1">
<tr>
<td class="tdmain" colspan="2" style="background-color: #ffff80">
<img src="img/logo.jpg" alt="Railways in Poland" width="400" height="100" border="0">
</td>
</tr>
<tr>
<td class="tdmain" style="background-color: #ddeeff; text-align: center;" colspan="2">
&nbsp;
</td>
</tr>
<tr>
<td class="tdmain" style="background-color: #0080c0; width: 25%;">
<!--MENU-->');
echo('<!--KWL-->
<span class="header"><b>Main menu</b></span><br><img src="img/hr.gif" width="120" height="1" alt=""><br><br>
<a href="gal/gal.php" class="menu"><img src="img/this.gif" alt="&gt;" align="middle" border="0" width="10" height="10"><b>Railway Gallery</b></a><br>
<a href="?id=infr" class="menu"><img src="img/this.gif" alt="&gt;" align="middle" border="0" width="10" height="10">Infrastructure</a><br>
<a href="?id=misc" class="menu"><img src="img/this.gif" alt="&gt;" align="middle" border="0" width="10" height="10">Photo miscellany</a><br><br>
<span class="header"><b>The author</b></span><br><img src="img/hr.gif" width="120" height="1" alt=""><br><br>
<a href="http://piotrd.czuby.net/" class="menu"><img src="img/this.gif" alt="&gt;" align="middle" border="0" width="10" height="10">peterd.profile</a><br><br>
<span class="header"><b>The website</b></span><br><img src="img/hr.gif" width="120" height="1" alt=""><br><br>
<a href="?id=tech" class="menu"><img src="img/this.gif" alt="&gt;" align="middle" border="0" width="10" height="10">Technical information</a><br><br>
<!--MENU end-->
</td>
<td class="tdmain" style="background-color: white; width: 75%;">
<!--INVISIBLE-->
<table class="invisible" border="0" align="center">
<tr>
<td class="tdinvisible">
<!--LEFT-->');
//															   BESTPHOTO
if (file_exists($votefile)) {
$votes=file($votefile);
$vote_array=array();
foreach ($votes as $vote) {
$vote=explode("^",$vote);
$vote_array[$vote[0]]=$vote[1];
}
arsort($vote_array);
$best=key($vote_array);
$best=explode("/",$best);
$best_location=$best[0].'/'.$best[1].'/'.$best[2];
$best_locationsmall=$best[0].'/'.$best[1].'/small/'.$best[2];
echo('<table class="window" cellpadding="1" cellspacing="1">
<tr>
<td class="tdwindow" style="background-color: #0080c0;">
<span class="header">The photograph of the month</span>
</td>
<tr>
<td class="tdwindow" style="background-color: #ffff80;">
<p style="text-align: center;">
<a href="javascript:photo(\''.$best_location.'\',\''.imgsize($best_location,"w").'\',\''.imgsize($best_location,"h").'\',\'The photograph of the month\')"><img src="'.$best_locationsmall.'" border="0" '.imgsize($best_locationsmall,"wh").' alt="The photograph of the month"></a><br><br>
<span class="small"><b>T</b>he photograph chosen by the internauts. Every visitor can vote once a month. You can find the appropriate link near each photograph.&nbsp;<b>'.count_lines($voteipfile).'</b> visitors have already voted this month.</span></p>
</td>
</tr>
</table>
<!--BESTPHOTO end-->
<br>');
}
//															   BESTPHOTO end
#echo('<b>H</b>ere you can see the list of the photographs published in the <a href="gal/gal.php">gallery</a> in <b>'.date("F Y",time()).'</b>.<br>');
#if (!($date)) {
#$date=date("nY",time());
#}
#$gal=opendir('gal');
#$i=1;
#while (($galdir=readdir($gal)) !== false) {
#if (is_dir('gal/'.$galdir)) {
#$dir=opendir('gal/'.$galdir);
#$desc=strtr($galdir,"abcdefghijklmnopqrstuvwxyz","ABCDEFGHIJKLMNOPQRSTUVWXYZ");
#$j=0;
#while (($file=readdir($dir)) !== false) {
#$location='gal/'.$galdir.'/'.$file;
#if (preg_match("/\w+\.jpg/",$file) && date("nY",filemtime($location))==$date) {
#$j=$j+1;
#if ($j==1) {
#$name='<br><b>'.$desc.':&nbsp;</b>';
#$name2=rtrim($file,"/\.jpg/");
#$name2=explode("-",$name2);
#$name.=$name2[0];
#} else {
#$name_beta=rtrim($file,"/\.jpg/");
#if ($name_beta!=$galdir) {
#$name2=rtrim($file,"/\.jpg/");
#$name2=explode("-",$name2);
#$name=$name2[0];
#}
#}
#if ($i!=1) {
#echo(', ');
#}
#echo($name);
#$i++;
#}
#}
#}
#}
#$i=$i-1;
echo('
<!--RANDOM-->
<table class="window" cellpadding="1" cellspacing="1">
<tr>
<td class="tdwindow" style="background-color: #0080c0;">
<span class="header">5 photographs from the gallery</span>
</td>
<tr>
<td class="tdwindow" style="background-color: #ffff80;">
<p style="text-align: center;">');
function getloco($location) {
$location=explode("/",$location);
$loco=explode("-",$location[0]);
$location=explode("-",$location[1]);
$loco=$loco[0].': '.$location[0];
$loco=strtr($loco,"adeklmnprstuw","ADEKLMNPRSTUW");
$loco=rtrim($loco);
return $loco;
}
$images=array();
$randomphotoslist=file('source/randomphotos.txt');
foreach ($randomphotoslist as $randomphoto) {
array_push($images,$randomphoto);
}
$imagestablesize=count($images)-1;
if (is_int($imagestablesize/5)) {
$im_fraction=$imagestablesize/5;
} else {
$im_fraction=($imagestablesize/5)-0.5;
}
$nr=rand(0,$im_fraction);
$nr2=rand($im_fraction+1,$im_fraction*2);
$nr3=rand($im_fraction*2+1,$im_fraction*3);
$nr4=rand($im_fraction*3+1,$im_fraction*4);
$nr5=rand($im_fraction*4+1,$im_fraction*5);
$bigphoto=$images[$nr];
$bigphoto2=$images[$nr2];
$bigphoto3=$images[$nr3];
$bigphoto4=$images[$nr4];
$bigphoto5=$images[$nr5];
$bigphoto=rtrim($bigphoto);
$bigphoto2=rtrim($bigphoto2);
$bigphoto3=rtrim($bigphoto3);
$bigphoto4=rtrim($bigphoto4);
$bigphoto5=rtrim($bigphoto5);
$smallimage=explode("/",$bigphoto);
$smallimage2=explode("/",$bigphoto2);
$smallimage3=explode("/",$bigphoto3);
$smallimage4=explode("/",$bigphoto4);
$smallimage5=explode("/",$bigphoto5);
$smallphoto=$smallimage[0].'/small/'.$smallimage[1];
$smallphoto2=$smallimage2[0].'/small/'.$smallimage2[1];
$smallphoto3=$smallimage3[0].'/small/'.$smallimage3[1];
$smallphoto4=$smallimage4[0].'/small/'.$smallimage4[1];
$smallphoto5=$smallimage5[0].'/small/'.$smallimage5[1];
$alt='Photograph no. 1';
$alt2='Photograph no. 2';
$alt3='Photograph no. 3';
$alt4='Photograph no. 4';
$alt5='Photograph no. 5';
$random_location='gal/'.$bigphoto.'.jpg';
$random_location2='gal/'.$bigphoto2.'.jpg';
$random_location3='gal/'.$bigphoto3.'.jpg';
$random_location4='gal/'.$bigphoto4.'.jpg';
$random_location5='gal/'.$bigphoto5.'.jpg';
$random_locationsmall='gal/'.$smallphoto.'.jpg';
$random_locationsmall2='gal/'.$smallphoto2.'.jpg';
$random_locationsmall3='gal/'.$smallphoto3.'.jpg';
$random_locationsmall4='gal/'.$smallphoto4.'.jpg';
$random_locationsmall5='gal/'.$smallphoto5.'.jpg';
echo('<a href="javascript:photo(\''.$random_location.'\',\''.imgsize($random_location,"w").'\',\''.imgsize($random_location,"h").'\',\''.$alt.'\')"><img src="'.$random_locationsmall.'" border="0" '.imgsize($random_locationsmall,"wh").'alt="'.$alt.'"></a><br><br>
<a href="javascript:photo(\''.$random_location2.'\',\''.imgsize($random_location2,"w").'\',\''.imgsize($random_location2,"h").'\',\''.$alt2.'\')"><img src="'.$random_locationsmall2.'" border="0" '.imgsize($random_locationsmall2,"wh").'alt="'.$alt2.'"></a><br><br>
<a href="javascript:photo(\''.$random_location3.'\',\''.imgsize($random_location3,"w").'\',\''.imgsize($random_location3,"h").'\',\''.$alt3.'\')"><img src="'.$random_locationsmall3.'" border="0" '.imgsize($random_locationsmall3,"wh").'alt="'.$alt3.'"></a><br><br>
<a href="javascript:photo(\''.$random_location4.'\',\''.imgsize($random_location4,"w").'\',\''.imgsize($random_location4,"h").'\',\''.$alt4.'\')"><img src="'.$random_locationsmall4.'" border="0" '.imgsize($random_locationsmall4,"wh").'alt="'.$alt4.'"></a><br><br>
<a href="javascript:photo(\''.$random_location5.'\',\''.imgsize($random_location5,"w").'\',\''.imgsize($random_location5,"h").'\',\''.$alt5.'\')"><img src="'.$random_locationsmall5.'" border="0" '.imgsize($random_locationsmall5,"wh").'alt="'.$alt5.'"></a><br>');
echo('</p>
</td>
</tr>
</table>
<!--RANDOM end-->
</td>
<!--LEFT end-->
<td class="tdinvisible">
<!--RIGHT-->
<!--OIP-->
<table class="window" cellpadding="1" cellspacing="1">
<tr>
<td class="tdwindow" style="background-color: #0080c0;">
<span class="header">InfoPanel [20 last]</span>
</td>
<tr>
<td class="tdwindow" style="background-color: #ffff80;">');
include('source/ip_read.php');
ip_read(20,"ip");
echo('<p><a href="/ip/"><img src="img/this2.gif" width="10" height="10" alt="&gt;" border="0" align="middle">InfoPanel</a><br>
</td>
</tr>
</table>
<!--OIP end-->
<!--RIGHT end-->
</td>
</tr>
</table>
<!--INVISIBLE end-->
</td>
</tr>
<tr>
<td class="tdmain" style="background-color: #ddeeff; text-align: center;" colspan="2">
&copy;&nbsp;2002-'.date("Y",time()).'&nbsp;railway.eu.org&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Last modification: '.date("F d, Y",getlastmod()).'&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="?id=stats"><b>'.counter($address).'</b></a>&nbsp;visitors since 11.01.2002</td>
</tr>
</table>
<!--MAINTABLE end-->');
} ?>
</body>
</html>
