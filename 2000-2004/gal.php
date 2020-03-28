<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<?
include('../source/counter.php');
$address=strval($_SERVER['REMOTE_ADDR']);
// 	  	  	   		  			   			 				   				CONSTANTS
$links='Railway Gallery: <a href="gal.php?cat=pl">PL</a> | <a href="gal.php?cat=a">A</a> | <a href="gal.php?cat=bl">BL</a> | <a href="gal.php?cat=cz">CZ</a> | <a href="gal.php?cat=d">D</a> | <a href="gal.php?cat=hu">HU</a> | <a href="gal.php?cat=sk">SK</a> | <a href="gal.php?cat=ua">UA</a>';
$head='<META HTTP-EQUIV="content-type" CONTENT="text/html; CHARSET=iso-8859-2">
<link rel="StyleSheet" type="text/css" href="../main.old.css">
<script language="JavaScript" type="text/javascript" src="../js/photo.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/text.js"></script>';
$body1='</head>
<body>
<table border="0" align="center" class="main" cellpadding="1" cellspacing="1">
<tr>
<td class="tdmain" style="background-color: #FFFF80;">
<a href="../index.php"><img src="../img/logo.jpg" alt="Railways in Poland" width="400" height="100" border="0"></a>
</td>
</tr>
<tr>
<td class="tdmain" style="background-color: #0080c0;">';
$body2='</td>
</tr>
<tr>
<td class="tdmain" style="background-color: #ffff80;">';
if (isset($id)) {
$body2.=$links;
}
$body2.='<!--LOCOS-->
<table border="0" align="center" class="locos" cellpadding="1" cellspacing="1">';
//							  						 						CONSTANTS end
// 	  	  	   		  			   			 				   				FILE_COUNTER
function file_counter($serie) {
$handle=opendir($serie);
$files=array();
while ($file = readdir($handle)) { 
if (preg_match("/\w+\.jpg/",$file)) { 
array_push ($files,$file); 
} 
}
closedir($handle);
$filesnr=count($files);
$filesnr.=' pcs.';
return $filesnr;
}
//	   				   	   			  										FILE_COUNTER end
// 				   															VOTING
function vote($photo,$lang) {
$address=strval($_SERVER['REMOTE_ADDR']);
$votedate=date("m.Y",time());
$voteipfile='/home/piotrd/logs/voting-ip-'.$votedate.'.txt';
if (file_exists($voteipfile)) {
$iphandle=fopen($voteipfile,"r");
$ips=fread($iphandle,filesize($voteipfile));
$ips=explode("\n",$ips);
if (in_array($address,$ips)) {
$found=1;
}
}
if (!(isset($found))) {
$final='<br><a class="small" href="../index.php?id=voting&photo=gal/'.$photo.'"><img src="../img/this2.gif" alt="&gt;" align="middle" width="10" height="10" border="0">';
if ($lang=="pl") {
$final.='Głosuj na fotografię';
} else {
$final.='Vote for the photo';
}
$final.='</a>';
return $final;
}
}
//	   		   	  	  		   				VOTING end
//	   				   	  			  	   	 				   IMGSIZE
function imgsize($img,$param) {
if (file_exists($img)) {
$size=getimagesize($img);
if ($param=="w") {
return $size[0];
} elseif ($param=="h") {
return $size[1];
} elseif ($param=="wh") {
return $size[3];
}
}
}
//	   					 	   								   IMGSIZE end
if (isset($id)) {
if (preg_match("/\w+-\d+/",$id)) {
$href=explode("-",$id);
$src=$href[0].'-'.$href[1];
$range_b=$href[2];
$range_e=$href[3];
$range_e=$range_e+0.9;
} else {
$src=$id;
if (!(file_exists('source/'.$src.'.txt'))) {
$range_b=0;
$range_e=100000;
}
}
$title=strtr($src,"abcdefghijklmnopqrstuvwxyz_","ABCDEFGHIJKLMNOPQRSTUVWXYZ ");
$title2=$title;
if (preg_match("/\w+-\w+/",$title)) {
$title=rtrim($title,"A..Z ");
$title=rtrim($title,"-");
}
$nrs=$range_b.'-';
$range_be=explode(".",$range_e);
if ($range_e<100) {
$nrs.=0;
}
$nrs.=rtrim($range_e,".9");
}
// 					   			   											ELECTRIC
if (isset($id) || isset($cat) || isset($find)) {
if ($find) {
$title2='PhotoSearch';
}
$meta='<META NAME="keywords" CONTENT="'.$title.' '.$title2.' Railways in '.$cat.' '.$id.' railways trams buses trolleybuses metro underground subway poland europe">
<META NAME="description" CONTENT="Railways in Poland/Railway Gallery/'.$title2.'">';
echo($meta.$head.'
<title>Railways in Poland/Railway Gallery/'.$title2.'</title>'.
$body1);
if (isset($id)) {
if (preg_match("/pkp/",$id) || preg_match("/pl/",$id) || preg_match("/bc/",$id) || preg_match("/uz/",$id) || preg_match("/lhs/",$id) || preg_match("/ctl/",$id) || preg_match("/transoda/",$id) || preg_match("/kp_szczakowa/",$id)) {
$dash='-';
} else {
$dash='&nbsp;';
}
if (preg_match("/\w+-\d+/",$id)) {
$href=explode("-",$id);
echo ('<a href="../index.php" class="menu">/RiP/</a><a href="gal.php" class="menu">Railway Gallery/</a><a href="gal.php?id='.$src.'" class="menu">'.$title2.'</a>&nbsp;<span class="header">'.$nrs.'</span>');
} else {
echo ('<a href="../index.php" class="menu">/RiP/</a><a href="gal.php" class="menu">Railway Gallery/</a><span class="header">'.$title2.'</span>');
}
echo ($body2);
$filename='source/'.$src.'-src.txt';
$lines=file($filename);
$description=array();
foreach ($lines as $desc_beta) {
$desc=explode("#",$desc_beta);
$description[$desc[0]]=$desc[1];
}
if (is_dir($src)) {
$h=opendir($src);
$descs=array();
while (($file = readdir($h)) !== false) {
$location=$src.'/'.$file;
$nr=rtrim($file,".jpg");
if (is_file($location) && ($nr/100)>=($range_b/100) && ($nr/100)<=($range_e/100)) {

#if (preg_match("/\w+-\w+/",$file)) {
#$file=explode("-",$file);
#$filenr=rtrim($file[1],".jpg");
#$file=$file[0].'.'.($file[1]/100).'.jpg';
#}

array_push($descs,$file);
}
}

function cmp($a, $b) { 
if ($a == $b) { 
return 0; 
} 

$a_b=explode("-",$a);
$b_b=explode("-",$b);
$a_c=rtrim($a_b[1],".jpg");
$b_c=rtrim($b_b[1],".jpg");
$a_c=$a_b[0]+($a_c/100);
$b_c=$b_b[0]+($b_c/100);

   return ($a_c < $b_c) ? -1 : 1; 
} 
usort($descs,"cmp"); 
#sort($descs,SORT_STRING);
#sort($descs,SORT_NUMERIC);

foreach ($descs as $file) {
$location=$src.'/'.$file;
$nr=rtrim($file,".jpg");
$locationsmall=$src.'/small/'.$file;
$width=imgsize($location,"w");
$height=imgsize($location,"h");
$widthsmall=imgsize($locationsmall,"w");
$heightsmall=imgsize($locationsmall,"h");
#$size=filesize($location)/1000;
$desc=explode("^",$description[$nr]);
if (preg_match("/\w+\-\w+\.jpg/",$file) && !(preg_match("/\w+\-\w+\-\w+\.jpg/",$file))) {
$nr=explode("-",$nr);
$titlenr=strtr($nr[0],"abcdefghijklmnopqrstuvwxyz","ABCDEFGHIJKLMNOPQRSTUVWXYZ");
echo('<tr>
<td class="tdlocos" style="width: 30%;">
<a href="javascript:photo(\''.$location.'\',\''.$width.'\',\''.$height.'\',\''.$title.$dash.$titlenr.'\')"><img src="'.$locationsmall.'" alt="'.$location.'" border="0" width="'.$widthsmall.'" height="'.$heightsmall.'"></a>
</td>
<td class="tdlocos" style="width: 70%;">
<b>'.$title.$dash.$titlenr.':</b>&nbsp;'.$desc[1].'<br>
<span class="small">['.$desc[0].']</span><br>
'.vote($src."/".$file,"en").'<br>');
echo('</td>
</tr>');
} elseif (preg_match("/\w+\-\w+\-\w+\.jpg/",$file)) {
$nr=explode("-",$nr);
$titlenr=strtr($nr[0],"abcdefghijklmnopqrstuvwxyz","ABCDEFGHIJKLMNOPQRSTUVWXYZ");
if (preg_match("/\w+\-\w+\-1\.jpg/",$file)) {
echo ('<tr>
<td class="tdlocos" colspan="3">
<p>&nbsp;</p>
<div class="menu2">'.$title.$dash.$titlenr.'-'.$nr[1].'</div>
</td>
</tr>
<tr>
<td class="tdlocos" style="width: 30%;">
<a href="javascript:photo(\''.$location.'\',\''.$width.'\',\''.$height.'\',\''.$title.$dash.$titlenr.'-'.$nr[1].'\')"><img src="'.$locationsmall.'" alt="'.$location.'" border="0" width="'.$widthsmall.'" height="'.$heightsmall.'"></a>
</td>
<td class="tdlocos" style="width: 70%;">
<b>'.$title.$dash.$titlenr.'-'.$nr[1].':</b>&nbsp;'.$desc[1].'<br>
<span class="small">['.$desc[0].']</span><br>
'.vote($src."/".$file,"en").'<br>');
echo('</td>
</tr>');
} else {
echo('<tr>
<td class="tdlocos" style="width: 30%;">
<a href="javascript:photo(\''.$location.'\',\''.$width.'\',\''.$height.'\',\''.$title.$dash.$titlenr.'-'.$nr[1].'\')"><img src="'.$locationsmall.'" alt="'.$location.'" border="0" width="'.$widthsmall.'" height="'.$heightsmall.'"></a>
</td>
<td class="tdlocos" style="width: 70%;">
<b>'.$title.$dash.$titlenr.'-'.$nr[1].':</b>&nbsp;'.$desc[1].'<br>
<span class="small">['.$desc[0].']</span><br>
'.vote($src."/".$file,"en").'<br>');
echo('</td>
</tr>');
}
} elseif (preg_match("/.+\.jpg/",$file)) {
$titlenr=strtr($nr,"abcdefghijklmnopqrstuvwxyz","ABCDEFGHIJKLMNOPQRSTUVWXYZ");
echo ('<tr>
<td class="tdlocos" colspan="3">
<p>&nbsp;</p>
<div class="menu2">'.$title.$dash.$titlenr.'</div>
</td>
</tr>
<tr>
<td class="tdlocos" style="width: 30%;">
<a href="javascript:photo(\''.$location.'\',\''.$width.'\',\''.$height.'\',\''.$title.$dash.$titlenr.'\')"><img src="'.$locationsmall.'" alt="'.$location.'" border="0" width="'.$widthsmall.'" height="'.$heightsmall.'"></a>
</td>
<td class="tdlocos" style="width: 70%;">
<b>'.$title.$dash.$titlenr.':</b>&nbsp;'.$desc[1].'<br>
<span class="small">['.$desc[0].']</span><br>
'.vote($src."/".$file,"en").'<br>');
echo('</td>
</tr>');
}
}
if ((!(preg_match("/\//",$src))) && file_exists('source/'.$src.'.txt') && (!(preg_match("/\w+-\w+-\w+/",$id)))) {
include('source/'.$src.'.txt');
}
}
echo('</td>
</tr>
</table>
<!--MAIN end-->
');
} elseif (isset($cat) && $cat=="pl") {
echo ('<a href="../index.php" class="menu">/RiP/</a><a href="gal.php" class="menu">Railway Gallery/</a><span class="header">Poland</span>
</td>
</tr>
<tr>
<td class="tdmain" style="background-color: #ffff80;">
<p>'.$links.'</p>
<!--LOCOS-->
<table class="mainlocos" align="center" cellpadding="1" cellspacing="1">
<tr>
<td class="tdtabor2" colspan="3">
Electric shunting locomotives
</td>
</tr>
<tr>
<td class="tdmainlocos" colspan="3">
<a href="?id=em10-pkp">EM10</a>&nbsp;<span class="small">['.file_counter('em10-pkp').']</span>
</td>
</tr>
<tr>
<td class="tdtabor2" style="width: 33%;">
Electric passenger locomotives
</td>
<td class="tdtabor2" style="width: 33%;">
Electric freight locomotives
</td>
<td class="tdtabor2" style="width: 33%;">
Electric universal locomotives
</td>
</tr>
<tr>
<td class="tdmainlocos" style="width: 33%;">
<a href="?id=ep02-pkp">EP02</a>&nbsp;<span class="small">['.file_counter('ep02-pkp').']</span><br>
<a href="?id=ep03-pkp">EP03</a>&nbsp;<span class="small">['.file_counter('ep03-pkp').']</span><br>
<a href="?id=ep05-pkp">EP05</a>&nbsp;<span class="small">['.file_counter('ep05-pkp').']</span><br>
<a href="?id=ep07-pkp">EP07</a>&nbsp;<span class="small">['.file_counter('ep07-pkp').']</span><br>
<a href="?id=ep08-pkp">EP08</a>&nbsp;<span class="small">['.file_counter('ep08-pkp').']</span><br>
<a href="?id=ep09-pkp">EP09</a>&nbsp;<span class="small">['.file_counter('ep09-pkp').']</span>
</td>
<td class="tdmainlocos" style="width: 33%;">
<a href="?id=et21-pkp">ET21</a>&nbsp;<span class="small">['.file_counter('et21-pkp').']</span><br>
<a href="?id=et22-pkp">ET22</a>&nbsp;<span class="small">['.file_counter('et22-pkp').']</span><br>
<a href="?id=et40-pkp">ET40</a>&nbsp;<span class="small">['.file_counter('et40-pkp').']</span><br>
<a href="?id=et41-pkp">ET41</a>&nbsp;<span class="small">['.file_counter('et41-pkp').']</span><br>
<a href="?id=et42-pkp">ET42</a>&nbsp;<span class="small">['.file_counter('et42-pkp').']</span><br><br>
<div><b>Private operators</b></div>
<a href="?id=201e-ctl">201E/ET22 (CTL)</a>&nbsp;<span class="small">['.file_counter('201e-ctl').']</span><br>
<a href="?id=3e-ctl">3E/ET21 (CTL)</a>&nbsp;<span class="small">['.file_counter('3e-ctl').']</span><br>
<a href="?id=3e-kp_szczakowa">3E/ET21 (KP Szczakowa)</a>&nbsp;<span class="small">['.file_counter('3e-kp_szczakowa').']</span><br>
</td>
<td class="tdmainlocos" style="width: 33%;">
<a href="?id=eu06-pkp">EU06</a>&nbsp;<span class="small">['.file_counter('eu06-pkp').']</span><br>
<a href="?id=eu07-pkp">EU07</a>&nbsp;<span class="small">['.file_counter('eu07-pkp').']</span><br>
<a href="?id=eu20-pkp">EU20</a>&nbsp;<span class="small">['.file_counter('eu20-pkp').']</span>
</td>
</tr>
</td>
</tr>
<tr>
<td class="tdtabor2" style="width: 33%;">
Long-distance EMU\'s
</td>
<td class="tdtabor2" style="width: 33%;">
Low-platform designed EMU\'s
</td>
<td class="tdtabor2" style="width: 33%;">
High-platform designed EMU\'s
</td>
</tr>
<tr>
<td class="tdmainlocos" style="width: 33%;">
<a href="?id=ed72-pkp">ED72</a>&nbsp;<span class="small">['.file_counter('ed72-pkp').']</span><br>
<a href="?id=ed73-pkp">ED73</a>&nbsp;<span class="small">['.file_counter('ed73-pkp').']</span>
</td>
<td class="tdmainlocos" style="width: 33%;">
<a href="?id=en56-pkp">EN56</a>&nbsp;<span class="small">['.file_counter('en56-pkp').']</span><br>
<a href="?id=en57-pkp">EN57</a>&nbsp;<span class="small">['.file_counter('en57-pkp').']</span><br>
<a href="?id=en57-skm">EN57 (SKM)</a>&nbsp;<span class="small">['.file_counter('en57-skm').']</span><br>
<a href="?id=en71-pkp">EN71</a>&nbsp;<span class="small">['.file_counter('en71-pkp').']</span><br>
<a href="?id=en71-skm">EN71 (SKM)</a>&nbsp;<span class="small">['.file_counter('en71-skm').']</span><br>
<a href="?id=en80-pkp">EN80</a>&nbsp;<span class="small">['.file_counter('en80-pkp').']</span><br>
<a href="?id=en94-pkp">EN94</a>&nbsp;<span class="small">['.file_counter('en94-pkp').']</span><br><br>
</td>
<td class="tdmainlocos" style="width: 33%;">
<a href="?id=ew51-pkp">EW51</a>&nbsp;<span class="small">['.file_counter('ew51-pkp').']</span><br>
<a href="?id=ew58-pkp">EW58</a>&nbsp;<span class="small">['.file_counter('ew58-pkp').']</span><br>
<a href="?id=ew60-pkp">EW60</a>&nbsp;<span class="small">['.file_counter('ew60-pkp').']</span>
</td>
</tr>
<tr>
<td class="tdtabor2" style="width: 33%;">
Diesel shunting locomotives
</td>
<td class="tdtabor2" style="width: 33%;">
Diesel passenger locomotives
</td>
<td class="tdtabor2" style="width: 33%;">
Diesel universal locomotives
</td>
</tr>
<tr>
<td class="tdmainlocos" style="width: 33%;">
<a href="?id=sm03-pkp">SM03</a>&nbsp;<span class="small">['.file_counter('sm03-pkp').']</span><br>
<a href="?id=sm15-pkp">SM15</a>&nbsp;<span class="small">['.file_counter('sm15-pkp').']</span><br>
<a href="?id=sm25-pkp">SM25</a>&nbsp;<span class="small">['.file_counter('sm25-pkp').']</span><br>
<a href="?id=sm30-pkp">SM30</a>&nbsp;<span class="small">['.file_counter('sm30-pkp').']</span><br>
<a href="?id=sm31-pkp">SM31</a>&nbsp;<span class="small">['.file_counter('sm31-pkp').']</span><br>
<a href="?id=sm41-pkp">SM41</a>&nbsp;<span class="small">['.file_counter('sm41-pkp').']</span><br>
<a href="?id=sm42-pkp">SM42</a>&nbsp;<span class="small">['.file_counter('sm42-pkp').']</span><br>
<a href="?id=sm48-pkp">SM48</a>&nbsp;<span class="small">['.file_counter('sm48-pkp').']</span><br>
<a href="?id=sm48-lhs">SM48 (LHS)</a>&nbsp;<span class="small">['.file_counter('sm48-lhs').']</span><br><br>
<div><b>Private operators</b></div>
<a href="?id=401da-pl">401Da</a>&nbsp;<span class="small">['.file_counter('401da-pl').']</span><br>
<a href="?id=409da-pl">409Da</a>&nbsp;<span class="small">['.file_counter('409da-pl').']</span><br>
<a href="?id=418d-pl">418D</a>&nbsp;<span class="small">['.file_counter('418d-pl').']</span><br>
<a href="?id=418da-pl">418Da</a>&nbsp;<span class="small">['.file_counter('418da-pl').']</span><br>
<a href="?id=ls40-pl">Ls40</a>&nbsp;<span class="small">['.file_counter('ls40-pl').']</span><br>
<a href="?id=ls60-pl">Ls60</a>&nbsp;<span class="small">['.file_counter('ls60-pl').']</span><br>
<a href="?id=ls150-pl">Ls150/SM03</a>&nbsp;<span class="small">['.file_counter('ls150-pl').']</span><br>
<a href="?id=ls300-pl">Ls300/SM30</a>&nbsp;<span class="small">['.file_counter('ls300-pl').']</span><br>
<a href="?id=ls800-pl">Ls800/SM42</a>&nbsp;<span class="small">['.file_counter('ls800-pl').']</span><br>
<a href="?id=s200-pl">S200</a>&nbsp;<span class="small">['.file_counter('s200-pl').']</span><br>
<a href="?id=sm42-lotos_kolej">SM42 (Lotos Kolej)</a>&nbsp;<span class="small">['.file_counter('sm42-lotos_kolej').']</span><br>
<a href="?id=tem2-pl">TEM2/SM48</a>&nbsp;<span class="small">['.file_counter('tem2-pl').']</span><br>
<a href="?id=t448p-pl">T448-P</a>&nbsp;<span class="small">['.file_counter('t448p-pl').']</span>
</td>
<td class="tdmainlocos" style="width: 33%;">
<a href="?id=sp30-pkp">SP30</a>&nbsp;<span class="small">['.file_counter('sp30-pkp').']</span><br>
<a href="?id=sp32-pkp">SP32</a>&nbsp;<span class="small">['.file_counter('sp32-pkp').']</span><br>
<a href="?id=sp42-pkp">SP42</a>&nbsp;<span class="small">['.file_counter('sp42-pkp').']</span><br>
<a href="?id=sp45-pkp">SP45</a>&nbsp;<span class="small">['.file_counter('sp45-pkp').']</span><br>
<a href="?id=sp47-pkp">SP47</a>&nbsp;<span class="small">['.file_counter('sp47-pkp').']</span><br>
</td>
<td class="tdmainlocos" style="width: 33%;">
<a href="?id=su42-pkp">SU42</a>&nbsp;<span class="small">['.file_counter('su42-pkp').']</span><br>
<a href="?id=su45-pkp">SU45</a>&nbsp;<span class="small">['.file_counter('su45-pkp').']</span><br>
<a href="?id=su46-pkp">SU46</a>&nbsp;<span class="small">['.file_counter('su46-pkp').']</span><br>
</td>
</tr>
<tr>
<td class="tdtabor2" colspan="3">
Diesel freight locomotives
</td>
</tr>
<tr>
<td class="tdmainlocos" colspan="3">
<a href="?id=st43-pkp">ST43</a>&nbsp;<span class="small">['.file_counter('st43-pkp').']</span><br>
<a href="?id=st44-pkp">ST44</a>&nbsp;<span class="small">['.file_counter('st44-pkp').']</span><br>
<a href="?id=st44-lhs">ST44 (LHS)</a>&nbsp;<span class="small">['.file_counter('st44-lhs').']</span><br><br>
</td>
</tr>
</td>
</tr>
<tr>
<td class="tdtabor2" colspan="2">
Diesel motor units
</td>
<td class="tdtabor2">
Diesel motor cars
</td>
</tr>
<tr>
<td class="tdmainlocos" colspan="2">
<a href="?id=sa101-pkp">SA101/121</a>&nbsp;<span class="small">['.file_counter('sa101-pkp').']</span><br>
<a href="?id=sa102-pkp">SA102/111</a>&nbsp;<span class="small">['.file_counter('sa102-pkp').']</span><br>
<a href="?id=sa105-pkp">SA105</a>&nbsp;<span class="small">['.file_counter('sa105-pkp').']</span><br>
<a href="?id=sa106-pkp">SA106</a>&nbsp;<span class="small">['.file_counter('sa106-pkp').']</span><br>
<a href="?id=sa107-pkp">SA107</a>&nbsp;<span class="small">['.file_counter('sa107-pkp').']</span><br>
<a href="?id=sa108-pkp">SA108</a>&nbsp;<span class="small">['.file_counter('sa108-pkp').']</span><br>
<a href="?id=sa109-pkp">SA109</a>&nbsp;<span class="small">['.file_counter('sa109-pkp').']</span><br>
<a href="?id=sn81-pkp">SN81</a>&nbsp;<span class="small">['.file_counter('sn81-pkp').']</span>
</td>
<td class="tdmainlocos">
<a href="?id=em120-pkp">EM120</a>&nbsp;<span class="small">['.file_counter('em120-pkp').']</span><br>
<a href="?id=sn61-pkp">SN61</a>&nbsp;<span class="small">['.file_counter('sn61-pkp').']</span><br>
<a href="?id=sr53-pkp">SR53</a>&nbsp;<span class="small">['.file_counter('sr53-pkp').']</span><br>
<a href="?id=sr71-pkp">SR71</a>&nbsp;<span class="small">['.file_counter('sr71-pkp').']</span>
</td>
</tr>
<tr>
<td class="tdtabor2">
Passenger steam locos
</td>
<td class="tdtabor2">
Fast steam locos
</td>
<td class="tdtabor2">
Freight steam locos
</td>
</tr>
<tr>
<td class="tdmainlocos">
<a href="?id=ok1-pkp">Ok1</a>&nbsp;<span class="small">['.file_counter('ok1-pkp').']</span><br>
<a href="?id=ol49-pkp">Ol49</a>&nbsp;<span class="small">['.file_counter('ol49-pkp').']</span><br>
</td>
<td class="tdmainlocos">
<a href="?id=pt47-pkp">Pt47</a>&nbsp;<span class="small">['.file_counter('pt47-pkp').']</span><br>
</td>
<td class="tdmainlocos">
<a href="?id=tkt48-pkp">TKt48</a>&nbsp;<span class="small">['.file_counter('tkt48-pkp').']</span><br>
<a href="?id=tr5-pkp">Tr5</a>&nbsp;<span class="small">['.file_counter('tr5-pkp').']</span><br>
<a href="?id=ty2-pkp">Ty2</a>&nbsp;<span class="small">['.file_counter('ty2-pkp').']</span><br>
<a href="?id=ty45-pkp">Ty45</a>&nbsp;<span class="small">['.file_counter('ty45-pkp').']</span>
</td>
</tr>
<tr>
<td class="tdtabor2" colspan="2">
OHLE maintenance vehicles
</td>
<td class="tdtabor2" colspan="1">
Other vehicles
</td>
</tr>
<tr>
<td class="tdmainlocos" colspan="2">
<a href="?id=ps00-pkp">PS-00</a>&nbsp;<span class="small">['.file_counter('ps00-pkp').']</span><br>
<a href="?id=pwm05p-pkp">PWM05P</a>&nbsp;<span class="small">['.file_counter('pwm05p-pkp').']</span>
</td>
<td class="tdmainlocos" colspan="1">
<a href="?id=asf-pkp">ASF</a>&nbsp;<span class="small">['.file_counter('asf-pkp').']</span>
</td>
</tr>
<tr>
<td class="tdtabor2" style="width: 33%;">
Railway cranes
</td>
<td class="tdtabor2" style="width: 33%;">
Snow ploughs
</td>
<td class="tdtabor2" style="width: 33%;">
Track maintenance vehicles
</td>
</tr>
<tr>
<td class="tdmainlocos" style="width: 33%;">
<a href="?id=edk80-pkp">EDK-80</a>&nbsp;<span class="small">['.file_counter('edk80-pkp').']</span><br>
<a href="?id=edk300-pkp">EDK-300</a>&nbsp;<span class="small">['.file_counter('edk300-pkp').']</span>
</td>
<td class="tdmainlocos" style="width: 33%;">
<a href="?id=411s-pkp">411s</a>&nbsp;<span class="small">['.file_counter('411s-pkp').']</span><br>
<a href="?id=pse-pkp">PSE</a>&nbsp;<span class="small">['.file_counter('pse-pkp').']</span><br>
<a href="?id=psea-pkp">PSEA</a>&nbsp;<span class="small">['.file_counter('psea-pkp').']</span><br>
<a href="?id=spdm-pkp">SPDM</a>&nbsp;<span class="small">['.file_counter('spdm-pkp').']</span>
</td>
<td class="tdmainlocos" style="width: 33%;">
<a href="?id=dgs-pkp">DGS</a>&nbsp;<span class="small">['.file_counter('dgs-pkp').']</span><br>
<a href="?id=prs07-pkp">PRS-07</a>&nbsp;<span class="small">['.file_counter('prs07-pkp').']</span><br>
<a href="?id=prsm04-pkp">PRSM-04</a>&nbsp;<span class="small">['.file_counter('prsm04-pkp').']</span><br>
<a href="?id=ptmd68-pkp">PT-MD-68</a>&nbsp;<span class="small">['.file_counter('ptmd68-pkp').']</span><br>
<a href="?id=svp-pkp">SVP</a>&nbsp;<span class="small">['.file_counter('svp-pkp').']</span><br>
<a href="?id=wm15a-pkp">WM-15A</a>&nbsp;<span class="small">['.file_counter('wm15a-pkp').']</span><br>
<a href="?id=ztu300-pkp">ZTU-300</a>&nbsp;<span class="small">['.file_counter('ztu300-pkp').']</span>
</td>
</tr>
</td>
</tr>
</table>
<!--MAIN end-->
'); 
//								   											PKP end
} elseif (isset($cat) && $cat=="cz") {
//		 							  										 CZ
echo ('<a href="../index.php" class="menu">/RiP/</a><a href="gal.php" class="menu">Railway Gallery/</a><span class="header">Czech Republic</span>
</td>
</tr>
<tr>
<td class="tdmain" style="background-color: #ffff80;">
<p>'.$links.'</p>
<!--LOCOS-->
<table class="mainlocos" align="center" cellpadding="1" cellspacing="1">
<tr>
<td class="tdtabor2" style="width: 33%;">
EMU\'s
</td>
<td class="tdtabor2" style="width: 33%;">
Electric locomotives
</td>
<td class="tdtabor2" style="width: 33%;">
Diesel locomotives
</td>
</tr>
<tr>
<td class="tdmainlocos" style="width: 33%;">
<a href="?id=560-cd">560</a>&nbsp;<span class="small">['.file_counter('560-cd').']</span><br>
</td>
<td class="tdmainlocos" style="width: 33%;">
<a href="?id=182-cd">182</a>&nbsp;<span class="small">['.file_counter('182-cd').']</span><br>
<a href="?id=210-cd">210</a>&nbsp;<span class="small">['.file_counter('210-cd').']</span><br>
<a href="?id=230-cd">230</a>&nbsp;<span class="small">['.file_counter('230-cd').']</span><br>
<a href="?id=263-cd">263</a>&nbsp;<span class="small">['.file_counter('263-cd').']</span><br>
<a href="?id=242-cd">242</a>&nbsp;<span class="small">['.file_counter('242-cd').']</span><br>
<a href="?id=363-cd">363</a>&nbsp;<span class="small">['.file_counter('363-cd').']</span><br>
</td>
<td class="tdmainlocos" style="width: 33%;">
<a href="?id=708-cd">708</a>&nbsp;<span class="small">['.file_counter('708-cd').']</span><br>
<a href="?id=714-cd">714</a>&nbsp;<span class="small">['.file_counter('714-cd').']</span><br>
<a href="?id=740-cd">740</a>&nbsp;<span class="small">['.file_counter('740-cd').']</span><br>
<a href="?id=742-cd">742</a>&nbsp;<span class="small">['.file_counter('742-cd').']</span><br>
<a href="?id=749-cd">749</a>&nbsp;<span class="small">['.file_counter('749-cd').']</span><br>
<a href="?id=754-cd">754</a>&nbsp;<span class="small">['.file_counter('754-cd').']</span><br>
</td>
</tr>
<tr>
<td class="tdtabor2" style="width: 33%">
DMU\'s
</td>
<td class="tdtabor2" style="width: 33%">
Carriages
</td>
<td class="tdtabor2" style="width: 33%">
Special
</td>
</tr>
<tr>
<td class="tdmainlocos" style="width: 33%">
<a href="?id=810-cd">810</a>&nbsp;<span class="small">['.file_counter('810-cd').']</span><br>
</td>
<td class="tdmainlocos" style="width: 33%">
<a href="?id=010-cd">010</a>&nbsp;<span class="small">['.file_counter('010-cd').']</span><br>
<a href="?id=012-cd">012</a>&nbsp;<span class="small">['.file_counter('012-cd').']</span><br>
<a href="?id=021-cd">021</a>&nbsp;<span class="small">['.file_counter('021-cd').']</span><br>
</td>
<td class="tdmainlocos" style="width: 33%">
<a href="?id=muv69-cd">MUV69</a>&nbsp;<span class="small">['.file_counter('muv69-cd').']</span><br>
<a href="?id=mvtv2-cd">MVTV2</a>&nbsp;<span class="small">['.file_counter('mvtv2-cd').']</span><br>
</td>
</tr>
</table>
<!--MAIN end-->
');
//									 							   	 				CD end
} elseif (isset($cat) && $cat=="a") {
//		 							  										 A
echo ('<a href="../index.php" class="menu">/RiP/</a><a href="gal.php" class="menu">Railway Gallery/</a><span class="header">Austria</span>
</td>
</tr>
<tr>
<td class="tdmain" style="background-color: #ffff80;">
<p>'.$links.'</p>
<!--LOCOS-->
<table class="mainlocos" align="center" cellpadding="1" cellspacing="1">
<tr>
<td class="tdtabor2">
Electric locomotives
</td>
</tr>
<tr>
<td class="tdmainlocos">
<a href="?id=1116-obb">1116</a>&nbsp;<span class="small">['.file_counter('1116-obb').']</span><br>
</td>
</tr>
</table>
<!--MAIN end-->
');
//										A end
} elseif (isset($cat) && $cat=="hu") {
//		 							  										 CD
echo ('<a href="../index.php" class="menu">/RiP/</a><a href="gal.php" class="menu">Railway Gallery/</a><span class="header">Hungary</span>
</td>
</tr>
<tr>
<td class="tdmain" style="background-color: #ffff80;">
<p>'.$links.'</p>
<!--LOCOS-->
<table class="mainlocos" align="center" cellpadding="1" cellspacing="1">
<tr>
<td class="tdtabor2" style="width: 50%;">
Electric locomotives
</td>
<td class="tdtabor2" style="width: 50%;">
Diesel locomotives
</td>
</tr>
<tr>
<td class="tdmainlocos" style="width: 50%;">
<a href="?id=1047-mav">1047</a>&nbsp;<span class="small">['.file_counter('1047-mav').']</span><br>
<a href="?id=v43-mav">V43</a>&nbsp;<span class="small">['.file_counter('v43-mav').']</span><br>
<a href="?id=v43-gysev">V43 (GySEV)</a>&nbsp;<span class="small">['.file_counter('v43-gysev').']</span><br>
</td>
<td class="tdmainlocos" style="width: 50%;">
<a href="?id=m40-mav">M40</a>&nbsp;<span class="small">['.file_counter('m40-mav').']</span><br>
<a href="?id=m47-mav">M47</a>&nbsp;<span class="small">['.file_counter('m47-mav').']</span><br>
<a href="?id=m62-mav">M62</a>&nbsp;<span class="small">['.file_counter('m62-mav').']</span><br>
</td>
</tr>
</table>
<!--MAIN end-->
');
//										HU end
} elseif (isset($cat) && $cat=="sk") {
//		 							  										 SK
echo ('<a href="../index.php" class="menu">/RiP/</a><a href="gal.php" class="menu">Railway Gallery/</a><span class="header">Slovakia</span>
</td>
</tr>
<tr>
<td class="tdmain" style="background-color: #ffff80;">
<p>'.$links.'</p>
<!--LOCOS-->
<table class="mainlocos" align="center" cellpadding="1" cellspacing="1">
<tr>
<td class="tdtabor2">
Electric locomotives
</td>
</tr>
<tr>
<td class="tdmainlocos">
<a href="?id=110-zssk">110</a>&nbsp;<span class="small">['.file_counter('110-zssk').']</span><br>
<a href="?id=140-zssk">140</a>&nbsp;<span class="small">['.file_counter('140-zssk').']</span><br>
<a href="?id=350-zssk">350</a>&nbsp;<span class="small">['.file_counter('350-zssk').']</span><br>
<a href="?id=362-zssk">362</a>&nbsp;<span class="small">['.file_counter('362-zssk').']</span><br>
</td>
</tr>
</tr>
</table>
<!--MAIN end-->
');
//									 							   	 				SK end
} elseif (isset($cat) && $cat=="d") {
//		 							  										DE
echo ('<a href="../index.php" class="menu">/RiP/</a><a href="gal.php" class="menu">Railway Gallery/</a><span class="header">Germany</span>
</td>
</tr>
<tr>
<td class="tdmain" style="background-color: #ffff80;">
<p>'.$links.'</p>
<!--LOCOS-->
<table class="mainlocos" align="center" cellpadding="1" cellspacing="1">
<tr>
<td class="tdtabor2" style="width: 33%;">
Electric locomotives &amp; trains
</td>
<td class="tdtabor2" style="width: 33%;">
Diesel locomotives &amp; trains
</td>
<td class="tdtabor2" style="width: 33%;">
Railbuses
</td>
</tr>
<tr>
<td class="tdmainlocos" style="width: 33%;">
<a href="?id=110-db">110</a>&nbsp;<span class="small">['.file_counter('110-db').']</span><br>
<a href="?id=112-db">112</a>&nbsp;<span class="small">['.file_counter('112-db').']</span><br>
<a href="?id=481-db">481</a>&nbsp;<span class="small">['.file_counter('481-db').']</span><br>
<a href="?id=ice2-db">ICE 2</a>&nbsp;<span class="small">['.file_counter('ice2-db').']</span><br>
</td>
<td class="tdmainlocos" style="width: 33%;">
<a href="?id=218-db">218</a>&nbsp;<span class="small">['.file_counter('218-db').']</span><br>
<a href="?id=232-db">232</a>&nbsp;<span class="small">['.file_counter('232-db').']</span><br>
<a href="?id=624-db">624</a>&nbsp;<span class="small">['.file_counter('624-db').']</span><br>
<a href="?id=928-db">928</a>&nbsp;<span class="small">['.file_counter('928-db').']</span><br>
<a href="?id=bnrdzf-db">Bnrdzf</a>&nbsp;<span class="small">['.file_counter('bnrdzf-db').']</span><br>
</td>
<td class="tdmainlocos" style="width: 33%;">
<div><b>Private operators</b></div>
<a href="?id=lint-nob">Lint (NOB)</a>&nbsp;<span class="small">['.file_counter('lint-nob').']</span><br>
</td>
</tr>
</tr>
</table>
<!--MAIN end-->
');
//									 							   	 				DE end
} elseif (isset($cat) && $cat=="ua") {
//		 							  										UA
echo ('<a href="../index.php" class="menu">/RiP/</a><a href="gal.php" class="menu">Railway Gallery/</a><span class="header">Ukraine</span>
</td>
</tr>
<tr>
<td class="tdmain" style="background-color: #ffff80;">
<p>'.$links.'</p>
<!--LOCOS-->
<table class="mainlocos" align="center" cellpadding="1" cellspacing="1">
<tr>
<td class="tdtabor2" style="width: 50%;">
Diesel locomotives
</td>
<td class="tdtabor2" style="width: 50%;">
Electric locomotives
</td>
</tr>
<tr>
<td class="tdmainlocos" style="width: 50%;">
<a href="?id=2m62-uz">2M62</a>&nbsp;<span class="small">['.file_counter('2m62-uz').']</span><br>
</td>
<td class="tdmainlocos" style="width: 50%;">
<a href="?id=wl10-uz">WŁ10</a>&nbsp;<span class="small">['.file_counter('wl10-uz').']</span><br>
</td>
</tr>
</tr>
</table>
<!--MAIN end-->
');
//									 							   	 				UA end
} elseif (isset($cat) && $cat=="bl") {
//		 							  										BL
echo ('<a href="../index.php" class="menu">/RiP/</a><a href="gal.php" class="menu">Railway Gallery/</a><span class="header">Belarus</span>
</td>
</tr>
<tr>
<td class="tdmain" style="background-color: #ffff80;">
<p>'.$links.'</p>
<!--LOCOS-->
<table class="mainlocos" align="center" cellpadding="1" cellspacing="1">
<tr>
<td class="tdtabor2">
Diesel locomotives
</td>
</tr>
<tr>
<td class="tdmainlocos">
<a href="?id=2m62u-bc">2M62U</a>&nbsp;<span class="small">['.file_counter('2m62u-bc').']</span><br>
</td>
</tr>
</tr>
</table>
<!--MAIN end-->
');
//									 							   	 				BL end
} elseif (isset($find)) {
echo('<a href="../index.php" class="menu">/RiP/</a><a href="gal.php" class="menu">Railway Gallery/</a><span class="header">PhotoSearch: '.$find.'</span>
</td>
</tr>
<tr>
<td class="tdmain" style="background-color: #ffff80;">
<p>
<form method="GET" action="gal.php">
<input type="text" name="find" value="'.$find.'"><br>
<input type="submit" value="Search">
</form>
</p>
<table>');
$src='/home/piotrd/kwl/gal/source';
$source=opendir($src);
while (($file = readdir($source)) !== false) {
if (preg_match("/src\.txt/",$file)) {
$lines=file($src.'/'.$file);
$i=1;
foreach ($lines as $line) {
if (preg_match("/.{3}/",$find)) {
if (preg_match("/$find/i",$line)) {
$extract=explode("#",$line);
$extr=explode("^",$extract[1]);

$folder=explode("-",$file);
$folder=$folder[0].'-'.$folder[1];
$location=$folder.'/'.$extract[0].'.jpg';
$locationsmall=$folder.'/small/'.$extract[0].'.jpg';
$width=imgsize($location,"w");
$height=imgsize($location,"h");
$widthsmall=imgsize($locationsmall,"w");
$heightsmall=imgsize($locationsmall,"h");

$title=strtr($folder,"abcdefghijklmnopqrstuvwxyz_","ABCDEFGHIJKLMNOPQRSTUVWXYZ ");
$titlenr=strtr($extract[0],"abcdefghijklmnopqrstuvwxyz","ABCDEFGHIJKLMNOPQRSTUVWXYZ");

if ($i==1) {
echo('<tr>
<td class="tdlocos" colspan="3">
<p>&nbsp;</p>
<div class="menu2">'.$title.'</div>
</td>
</tr>');
}

echo('<tr>
<td class="tdlocos" style="width: 30%;">
<a href="javascript:photo(\''.$location.'\',\''.$width.'\',\''.$height.'\',\''.$title.'/'.$titlenr.'\')"><img src="'.$locationsmall.'" alt="'.$location.'" border="0" width="'.$widthsmall.'" height="'.$heightsmall.'"></a>
</td>
<td class="tdlocos" style="width: 70%;">
<b>'.$title.'/'.$titlenr.':</b>&nbsp;'.$extr[1].'<br>
<span class="small">['.$extr[0].']</span><br>
'.vote($location,"en").'<br>
</td>
</tr>');
$i++;
}
}
}
}
}
echo('</tr></table>');
}
} else {
//	   	 							 												MAIN
echo ('<META NAME="keywords" CONTENT="transport railways in poland germany austria hungary ukraine slovakia czech republic trams metro underground buses trolleybusses trolleys belarussia belarus locomotives trains european urban transport rail">
<META NAME="description" CONTENT="Railways in Poland/Railway Gallery">
'.$head.'
<title>Railways in Poland/Gallery</title>'.$body1.'
<a href="../index.php" class="menu">/RiP/</a><span class="header">Railway Gallery</span>
'.$body2.'<p>&nbsp;</p>
<!--GALLERY-->
<table class="links" align="center" cellpadding="1" cellspacing="1" style="width: 400px;">
<tr>
<td class="tdtabor2" colspan="2">
Railway Gallery
</td>
</tr>
<tr>
<td class="tdmainlocos" style="text-align: left;" colspan="2">
<a href="gal.php?cat=pl"><img src="../img/this2.gif" alt="&gt;" align="middle" width="10" height="10" border="0"><b>Poland</b></a><br>
<a href="gal.php?cat=a"><img src="../img/this2.gif" alt="&gt;" align="middle" width="10" height="10" border="0"><b>Austria</b></a><br>
<a href="gal.php?cat=bl"><img src="../img/this2.gif" alt="&gt;" align="middle" width="10" height="10" border="0"><b>Belarus</b></a><br>
<a href="gal.php?cat=cz"><img src="../img/this2.gif" alt="&gt;" align="middle" width="10" height="10" border="0"><b>Czech Republic</b></a><br>
<a href="gal.php?cat=d"><img src="../img/this2.gif" alt="&gt;" align="middle" width="10" height="10" border="0"><b>Germany</b></a><br>
<a href="gal.php?cat=hu"><img src="../img/this2.gif" alt="&gt;" align="middle" width="10" height="10" border="0"><b>Hungary</b></a><br>
<a href="gal.php?cat=sk"><img src="../img/this2.gif" alt="&gt;" align="middle" width="10" height="10" border="0"><b>Slovakia</b></a><br>
<a href="gal.php?cat=ua"><img src="../img/this2.gif" alt="&gt;" align="middle" width="10" height="10" border="0"><b>Ukraine</b></a><br>
</td>
</tr>
<tr>
<td class="tdtabor2" colspan="2">
PhotoSearch
</td>
</tr>
<tr>
<td class="tdmainlocos" style="text-align: left;" colspan="2">
<p>
<form method="GET" action="gal.php">
<input type="text" name="find" value="'.$find.'"><br>
<input type="submit" value="Search">
</form>
</p>
</td>
</tr>
</table>
<!--MAIN end-->
');
}
if (isset($id) || isset($cat)) {
echo('<p>'.$links.'</p>');
} else {
echo('<p>&nbsp;</p>');
}
echo('</td>
</tr>
</td>
</tr>
<tr>
<td class="tdmain" style="background-color: #ddeeff;">
&copy; 2002-'.date("Y",time()).' railway.eu.org [<a href="../?id=stats"><b>'.counter($address));
?>
</b></a>]
</td>
</tr>
</table>
</body>
</html> 