<?
function ip_read($howmany,$src) {
if ($src=="ip") {
$mailfile='/home/piotrd/logs/ip/ip-src.txt';
} else {
$mailfile='/home/piotrd/logs/ip/'.$src.'.txt';
}
if (is_file($mailfile)) {
$file=fopen($mailfile,"r");
$file_content=fread($file,filesize($mailfile));
fclose($file);
$mailitems=explode("From procmail@localhost",$file_content);
if (count($mailitems) != 0) {
$info=array();
$i=1; 
foreach ($mailitems as $mailitem) {
$mailitem=explode("--",$mailitem);
$lines=explode("\n",$mailitem[0]);
foreach ($lines as $line) {
if (preg_match("/Date:/",$line)) {
$dateline=trim($line,"Date:");
$dateline=strtotime($dateline);
$date=date("d.m.Y H:i",$dateline);
if (date("d.m.Y",$dateline)==date("d.m.Y",time())) {
$colour='red';
} else {
$colour='black';
}
}
}
if (preg_match("/From:.*505924130@.*idea.*pl.*/",$mailitem[0]) && preg_match("/<.*ip>/",$mailitem[0])) {
$sender='peterd';
$header='';
} elseif (preg_match("/From:.*<piotrd@.*lublin.pl>/",$mailitem[0]) && preg_match("/Subject:.*<.*ip>/",$mailitem[0])) {
$sender='peterd_net';
$header='';
} elseif (preg_match("/From:.*<piotrd@czuby.net>/",$mailitem[0]) && preg_match("/Subject:.*<ip>/",$mailitem[0])) {
$sender='peterd_net';
$header='';
} elseif (preg_match("/From:.*48609817695@.*plusgsm.*pl.*/",$mailitem[0]) && preg_match("/Subject:.*<.*ip>/",$mailitem[0])) {
$sender='mpurc';
$header='';
} elseif (preg_match("/From:.*48691973772@.*plusgsm.*pl.*/",$mailitem[0]) && preg_match("/Subject:.*<.*ip>/",$mailitem[0])) {
$sender='klf';
$header='';
} elseif (preg_match("/From:.*48660769108@.*era.*pl.*/",$mailitem[0]) && preg_match("/Subject:.*<ip>/",$mailitem[0])) {
$sender='gmikosz';
$header='';
} elseif (preg_match("/From:.*48607555160@.*plusgsm.*pl.*/",$mailitem[0]) && preg_match("/Subject:.*<ip>/",$mailitem[0])) {
$sender='st44';
$header='';
} elseif (preg_match("/From:.*48697948587@.*plusgsm.*pl.*/",$mailitem[0]) && preg_match("/Subject:.*<ip>/",$mailitem[0])) {
$sender='msx';
$header='';
} else {
$sender='unauthorized';
}
if ($mailitem[2]!="") {
$mailitem[2]=rtrim($mailitem[2]);
$header='<span class="small" style="color: '.$colour.'"><b>#'.$i.'&nbsp;'.$mailitem[2].'</b></span>';
} else {
$header='';
}
if ($mailitem[1]!="" && $sender!="unauthorized") {
array_push($info,$header.'&nbsp;<span class="small" style="color: '.$colour.';">'.$date.'&nbsp;<b>'.$sender.'</b></span><br><span style="color: '.$colour.'">'.$mailitem[1].'</span>');
$i++;
}
}
}
if ((count($info)) != 0) {
if (!($sort) || $sort!="s") {
$info=array_reverse($info);
}
$i=0;
foreach ($info as $item) {
if ($i>=$howmany) {
break;
}
if ($item != $info[0]) {
echo('<br><br>');
}
echo($item);
$i++;
}
}
} else {
echo('No data');
}				
}
?>