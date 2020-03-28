<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<?
//	  	  	   		  			   			 				   					VARIABLES
include('source/counter.php');
$address=strval($_SERVER['REMOTE_ADDR']);
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
echo ('<META NAME="keywords" CONTENT="railways in europe, poland, koleje w polsce, railways in polandgermany czech republic, koleje w czechach, niemczech, impresje fotograficzne, kolejowe, galerie kolejowe, artystyczne, zdjêcia kolejowe, fotografia kolejowa, tabor, lokomotywy, poci±gi, pkp, cd, db, tory, infrastruktura kolejowa">
<META NAME="description" CONTENT="railways in europe - what else to say?">
<META http-equiv="author" content="Peter Piotr Damer">
<META HTTP-EQUIV="content-type" CONTENT="text/html; CHARSET=iso-8859-2">
<link rel="StyleSheet" type="text/css" href="main.css">
<title>railways in europe</title>
</head>
<body>
<!--MAINTABLE-->
<table border="0" align="center" cellpadding="1" cellspacing="1" style="width: 750px;">
<td style="background-color: #024a75; width: 150px;">
<!--MENU-->
<!--KWL-->
<p><span class="header"><b>to the point...</b></span><br><br>
<a href="http://www.railway.eu.org/" class="menu">home</a><br>
<a href="?id=news" class="menu">newies</a><br>
<a href="?id=monthly" class="menu"><b>monthly railscapes</b></a><br>
<a href="?id=themes" class="menu"><b>railthemes</b></a><br>
<a href="2000-2004/gal.php" class="menu">2000-2004 archives</a><br>
<a href="?id=links" class="menu">friendly links</a></p>
<p>&nbsp;</p>
<p><span class="header"><b>...and besides</b></span><br><br>
<a href="http://piotrd.czuby.net/" class="menu">author\'s profile</a><br>
<a href="?id=info" class="menu">website info</a></p>
<!--MENU end-->
</td>');
if ($id=="news") {
echo('<td style="background-color: #024a75; width: 600px; height: 400px; text-align: center;">
<p><b>newies</b></p>
<p>so, here we are. the concept is new and so is the record. let\'s go then.</p>
<p style="text-align: left;">
<b>july 23, 2006</b>&nbsp;the 1st update of the fresh website. the photos of may, june, july 2006 plus the first railtheme.<br>
<b>july 7, 2006</b>&nbsp;the new beginning. over four years after it was launched, the website - in fact - is starting from scratch. the archives remain, but it\'s not the point anymore. well, we\'ll see what is.
</p>
<p><b>the earlier history of the site</b></p>
<p>the record broke in mid-2004. then came a very chaotic period, marked by constant changes of layout, twists and turns of new ideas, and both visitor and content neclect. it\'s not that i don\'t want to write about it - i just can\'t - there\'s no coherent record and so i will leave it at that laconic summary.</p>
<p style="text-align: left;">
<b>june 29, 2004</b>&nbsp;101 new photographs: E20 trunk line (the vicinity of O³tarzew), Ma³aszewicze, ¯urawica. Furthermore 2 new classes - W£10 (UZ) and 2M62U (BC) plus streetcars.
<b>may 31, 2004</b>&nbsp;122 new photographs - mainly from the CMK trunk line (the vicinity of Rzêdkowice), LHS wide-gage line (Olkusz and surroundings), Poznañ, Tunel, Kutno and Zagórz. New classes: 140 (ZSR), 232 (DB), EU20, SM25 and Ty45.<br>
<b>march 27, 2004</b>&nbsp;368 new photographs - mostly from Poznañ and surroundings, Chodzie¿, Zduñska Wola Karsznice, Warszawa (Warsaw), Grodzisk Mazowiecki, Zagórz, Szczecin, Pszczyna, Czechowice-Dziedzice, Katowice, Tarnowskie Góry, the Tricity, Inowroc³aw and Zaj±czkowo Tczewskie. New classes (201E, 409Da, 418Da, EN80, EW51, SM15) plus \'Koleje S³owackie\' (\'Slovak Railways\') and \'Warszawskie metro\' (\'Warsaw Underground\').<br>
<b>december 08, 2003</b>&nbsp;132 new photographs - above all from the Tricity and Poznañ with its surroundings, Wolsztyn, Leszno, Wroc³aw and Ko³obrzeg. \'Best Photo Voting\' extended to \'Theme Galleries\'.<br>
<b>november 16, 2003</b>&nbsp;96 new photographs - mainly from the Tricity, Krzy¿ with surroundings, Poznañ and Ostrów Wielkopolski. New \'Best Photo Voting\' feature available.<br>
<b>october 26, 2003</b>&nbsp;281 new photographs - mainly from Czerwieñsk and surroundings, Olsztyn, Chojnice, the Tricity, Szczecin, Poznañ and Inowroc³awia. Website renamed to \'Koleje w Polsce\' (\'Railways in Poland\').<br>
<b>october 02, 2003</b>&nbsp;207 new photographs - from Zawiercie and Czêstochowa surroundings, £azy, the Tricity, Siedlce Poznañ and Czerwieñsk.<br>
<b>june 25, 2003</b>&nbsp;70 new photographs - mainly from Poznañ, Roztocze and Tarnowskie Góry.<br>
<b>may 31, 2003</b>&nbsp;161 new photographs - mainly from Nisko, Opole, Jas³o and Lublin with its surroundings.<br>
<b>april 06, 2003</b>&nbsp;73 new photographs from Lublin, Dêbica, Przeworsk and Skar¿ysko Kamienna. A new article on the \'WDOKP\'.<br>
<b>march 06, 2003</b>&nbsp;146 new photographs - mainly from the Tricity, Stalowa Wola, Lublin and Bydgoszcz. New class - EW60.<br>
<b>january 25, 2003</b>&nbsp;the great technological revolution - website transformation from HTML to PHP. Furthermore, over 100 new photoraphs - mainly from the Tricity. 2 new sections: \'EMU\'s\' and \'Railcars\'.<br>
<b>january 04, 2003</b>&nbsp;80 new photographs - mainly from Dorohusk, Na³êczów, Zawada and Hrubieszów, and a short article \'Po¿egnanie W³odawy\' (\'A Farewell to W³odawa\').<br>
<b>november 26, 2002</b>&nbsp;65 new photographs - mainly from Dêblin, Pilawa, Jaszczów, Przeworsk and £añcut. A new article - an account of the railway event on the Lublin-£uków line \'Trójk± do Lubartowa\'.<br>
<b>october 15, 2002</b>&nbsp;91 new photographs - mainly from Szczecin and its suroundings, Gryfino and Kutna. A new section - Theme Galleries. Plus a couple of new R.B.\'s pictures.<br>
<b>october 02, 2002</b>&nbsp;113 new photographs (including 5 new classes - ET40, ET42, Ls800, SM31 and ST43) mainly from Trójmiasto (The Tricity - Gdañsk-Sopot-and-Gdynia conurbation), Malbork, Grudzi±dz, ¦winouj¶cie and Poznañ.<br>
<b>september 06, 2002</b>&nbsp;99 new photographs (including a new class - Ls60) mainly from Chojnice, Szczecinek, Toruñ and Che³m.<br>
<b>june 20, 2002</b>&nbsp;47 new photographs (inluding 3 new classes: 401Da, SP42 and ST44) plus a new section - \'Rysunki Rafa³a Borowskiego\' (\'Rafa³ Borowski\'s Pictures\').<br>
<b>may 28, 2002</b>&nbsp;28 new photographs in the gallery.<br>
<b>may 22, 2002</b>&nbsp;the website moved onto the new server: lagoon.freebsd.lublin.pl, domain unchanged (kolej.czuby.net or www.kolej.czuby.net).<br>
<b>may 17, 2002</b>&nbsp;53 new photographs - mainly form £uków, Dêblin and Kraków (Cracow).<br>
<b>april 06, 2002</b>&nbsp;2 new classes (SM48 and SR71) and 27 new photographs. New section - \'Curiosities\'.<br>
<b>march 13, 2002</b>&nbsp;3 new locomotive classes (SP32, Ls40 and T448-P) plus further 32 photographs.<br>
<b>february 17, 2002</b>&nbsp;81 new photographs - 285 pieces altogether, plus an article on the Na³êczowskie Koleje Dojazdowe (Na³êczów narrow-gage railway).<br>
<b>january 25, 2002</b>&nbsp;the first update - 27 new photographs in the gallery and new articles artuku³y in \'Warsztat\' (\'The Workshop\') section.<br>
<b>january 11, 2002</b>&nbsp;the official opening of \'Koleje w Lublinie\' (\'Railways in Lublin\') website - 177 photographs in the gallery.<br>
<b>january 06, 2002</b>&nbsp;the website is finished, only server configuration yet to be done (virtual host and /cgi-bin/).<br>
<b>around May 20, 2001</b>&nbsp;the beginning of works at the website. In other words - the genesis.</p>
</td>');
} elseif ($id=="links") {
echo('<td style="background-color: #024a75; width: 600px; height: 400px; text-align: center;">
<p><b>friendly links</b></p>
<p style="text-align: left;">
<a href="http://www.kolej.lublin.joomlaserwer.com/">Lubelska strona kolejowa - Polish railway gallery from Lublin</a><br>
<a href="http://www.eu07.pl/~msx">MSX - strona kolejowa - railsite</a>
</p>
</td>');
} elseif ($id=="monthly") {
echo('<td style="background-color: #024a75; width: 600px; height: 400px; text-align: center;">');
$txtpath='monthly/'.$month.'.txt';
if (($month) && is_file($txtpath)) {
$m=explode(".",$month);
switch ($m[0]) {
case "01":
$headdate='january';
break;
case "02":
$headdate='february';
break;
case "03":
$headdate='march';
break;
case "04":
$headdate='april';
break;
case "05":
$headdate='may';
break;
case "06":
$headdate='june';
break;
case "07":
$headdate='july';
break;
case "08":
$headdate='august';
break;
case "09":
$headdate='september';
break;
case "10":
$headdate='october';
break;
case "11":
$headdate='november';
break;
case "12":
$headdate='december';
break;
}
$headdate=$headdate.' '.$m[1];
echo('<p><b>'.$headdate.'</b></p>');
$f=file($txtpath);
echo('<table class="invisible" align="center">');
foreach ($f as $line) {
$linee=explode("#",$line);
$line2e=explode("^",$linee[1]);
$imgpath='monthly/'.$month.'/'.$linee[0].'.jpg';
$smallimgpath='monthly/'.$month.'/small/'.$linee[0].'.jpg';
$imgwidth=imgsize($imgpath,"w");
$imgheight=imgsize($imgpath,"h");
echo('<tr>
<td class="invisible" style="width: 150px;">
<a href="show.php?path='.$imgpath.'&title='.$line2e[2].'&date='.$line2e[0].'&caption='.$line2e[1].'"><img src="'.$smallimgpath.'" '.imgsize($smallimgpath,"wh").' alt="'.$line2e[2].'" border="0"></a>
</td>
<td class="invisible">
<b>'.$line2e[2].'</b><br>
<p>'.$line2e[1].'<br>'.$line2e[0].'</p>
</td>
</tr>');
}
echo('</table>');
} else {
echo('<p><b>monthly railscapes</b></p>
<table class="invisible" align="center">
<tr>
<td class="invisible" style="width: 15%;">
<p><b>2006</b></p>
</td>
<td class="invisible" style="width: 85%;">
&nbsp;
</td>
</tr>
<tr>
<td class="invisible" style="width: 15%;">
<a href="?id=monthly&month=08.2006">august 2006</a>
</td>
<td class="invisible" style="width: 85%;">
&nbsp;
</td>
</tr>
<tr>
<td class="invisible" style="width: 15%;">
<a href="?id=monthly&month=07.2006">july 2006</a>
</td>
<td class="invisible" style="width: 85%;">
&nbsp;
</td>
</tr>
<tr>
<td class="invisible" style="width: 15%;">
<a href="?id=monthly&month=06.2006">june 2006</a>
</td>
<td class="invisible" style="width: 85%;">
&nbsp;
</td>
</tr>
<tr>
<td class="invisible" style="width: 15%;">
<a href="?id=monthly&month=05.2006">may 2006</a>
</td>
<td class="invisible" style="width: 85%;">
&nbsp;
</td>
</tr>
<tr>
<td class="invisible" style="width: 15%;">
<a href="?id=monthly&month=04.2006">april 2006</a>
</td>
<td class="invisible" style="width: 85%;">
&nbsp;
</td>
</tr>
<tr>
<td class="invisible" style="width: 15%;">
<a href="?id=monthly&month=03.2006">march 2006</a>
</td>
<td class="invisible" style="width: 85%;">
&nbsp;
</td>
</tr>
<tr>
<td class="invisible" style="width: 15%;">
<a href="?id=monthly&month=02.2006">february 2006</a>
</td>
<td class="invisible" style="width: 85%;">
&nbsp;
</td>
</tr>
<tr>
<td class="invisible" style="width: 15%;">
<a href="?id=monthly&month=01.2006">january 2006</a>
</td>
<td class="invisible" style="width: 85%;">
&nbsp;
</td>
</tr>
<tr>
<td class="invisible" style="width: 15%;">
&nbsp;
</td>
<td class="invisible" style="width: 85%;">
&nbsp;
</td>
</tr>
<tr>
<td class="invisible" style="width: 15%;">
<p><b>2005</b></p>
</td>
<td class="invisible" style="width: 85%;">
&nbsp;
</td>
</tr>
<tr>
<td class="invisible" style="width: 15%;">
<a href="?id=monthly&month=11.2005">november 2005</a>
</td>
<td class="invisible" style="width: 85%;">
&nbsp;
</td>
</tr>
<tr>
<td class="invisible" style="width: 15%;">
<a href="?id=monthly&month=10.2005">october 2005</a>
</td>
<td class="invisible" style="width: 85%;">
&nbsp;
</td>
</tr>
<tr>
<td class="invisible" style="width: 15%;">
<a href="?id=monthly&month=09.2005">september 2005</a>
</td>
<td class="invisible" style="width: 85%;">
&nbsp;
</td>
</tr>
</table>');
}
} elseif ($id=="themes") {
echo('<td style="background-color: #024a75; width: 600px; height: 400px; text-align: center;">');
$txtpath='themes/'.$theme.'.txt';
if (($theme) && is_file($txtpath)) {
switch ($theme) {
case "tiny":
$head='tiny details and lots of fun';
break;
case "izbica":
$head='izbica incident 2006';
break;
}
$head=$head.' '.$m[1];
echo('<p><b>'.$head.'</b></p>');
$f=file($txtpath);
echo('<table class="invisible" align="center">');
foreach ($f as $line) {
$linee=explode("#",$line);
$line2e=explode("^",$linee[1]);
$imgpath='themes/'.$theme.'/'.$linee[0].'.jpg';
$smallimgpath='themes/'.$theme.'/small/'.$linee[0].'.jpg';
$imgwidth=imgsize($imgpath,"w");
$imgheight=imgsize($imgpath,"h");
echo('<tr>
<td class="invisible" style="width: 150px;">
<a href="show.php?path='.$imgpath.'&title='.$line2e[2].'&date='.$line2e[0].'&caption='.$line2e[1].'"><img src="'.$smallimgpath.'" '.imgsize($smallimgpath,"wh").' alt="'.$line2e[2].'" border="0"></a>
</td>
<td class="invisible">
<b>'.$line2e[2].'</b><br>
<p>'.$line2e[1].'<br>'.$line2e[0].'</p>
</td>
</tr>');
}
echo('</table>');
} else {
echo('<p><b>railthemes</b></p>
<table class="invisible" align="center">
<tr>
<td class="invisible" style="width: 25%;">
<a href="?id=themes&theme=tiny">tiny details and lots of fun</a>
</td>
<td class="invisible" style="width: 75%;">
stop and stoop to see more
</td>
</tr>
<tr>
<td class="invisible" style="width: 25%;">
<p style="color: lightgray;">izbica incident 2006</p>
<!--<a href="?id=monthly&month=09.2005">izbica incident 2005</a>-->
</td>
<td class="invisible" style="width: 75%;">
the aftermaths of the accident near Izbica on march 29, 2006 at around 7.30am cet 
</td>
</tr>
</table>');
}
echo('</td>');
} else {
echo('<td style="background: url(img/home.jpg); width: 600px; height: 400px; text-align: center;">
<p>welcome to \'railways in europe\' - a gallery that has emerged from what was originally known as \'koleje w lublinie\' (\'railways in lublin\'), then \'railways in poland\' and - for a while - \'transport in poland\', each being nothing but a new nickname for the same concept. now, however, it is no more a large archival collection that this website is about. well, i have kept my earlier photographs online - they are available under the \'2000-2004 archives\' link, but the whole thing is like a closed chapter, which i do not think i will open again. now my aim is different - you will see it well. i hope you enjoy the new gallery.</p>
</td>');
}
echo('</tr>
<tr>
<td style="background-color: #024a75; text-align: center; width: 750px;" colspan="2">
&copy; 2002-'.date("Y",time()).' peter damer&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;last_mod: '.date("F d, Y",getlastmod()).'&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<b>'.counter($address).'</b> visitors since january 11, 2002
</td>
</tr>
</table>
<!--MAINTABLE end-->');
?>
</body>
</html>
