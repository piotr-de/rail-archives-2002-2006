<?
function counter() {
$address=strval($_SERVER['REMOTE_ADDR']);
$counter_file='/home/piotrd/logs/counter.txt';
if (!(file_exists($counter_file))) {
$count='Err!';
} else {
$dat=date("d.m.Y-a");
$dirdate=date("m.Y");
if (!(is_dir('/home/piotrd/logs/stats/'.$dirdate))) {
mkdir("/home/piotrd/logs/stats/".$dirdate,0777);
}
$filename='/home/piotrd/logs/stats/'.$dirdate.'/ip-'.$dat.'.txt';
$ip=fopen($filename, "a+");
$ipfile=file($filename);
flock($ip,LOCK_EX);
$ips=array();
foreach ($ipfile as $line) {
$line=explode(",",$line);
array_push($ips,$line[0]);
}
$fp = fopen($counter_file, "r+");
flock($fp,LOCK_EX);
$count = fgets($fp, 10);
$host=gethostbyaddr($address);
$agent=$_SERVER['HTTP_USER_AGENT'];
if (!(in_array($address,$ips)) && $address!="83.28.168.39" && !(preg_match("/bot/",$agent)) && !(preg_match("/Szukacz/",$agent)) && !(preg_match("/search/",$agent))) {
fwrite($ip,$address.", ".$host.", ".$agent.", ".$_SERVER['REQUEST_URI'].", ".date("H:i:s",time())."\n");
$count += 1;
fseek($fp, 0);
fwrite($fp, $count, 10);
}
flock($ip,LOCK_UN);
flock($fp,LOCK_UN);
fclose($ip);
fclose($fp);
}
return $count;
}
?>