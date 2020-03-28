<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<?
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
if (is_file($path)) {
$title=stripslashes($title);
$caption=stripslashes($caption);
echo('<head>
<META HTTP-EQUIV="content-type" CONTENT="text/html; CHARSET=iso-8859-2">
<title>'.$title.'</title>
</head>
<body style="background-color: #024a75;">
<p style="text-align: center;">
<a href="javascript:history.back();"><img src="'.$path.'" '.imgsize($path,"wh").' border="0" alt="'.$title.'"></a></p>
<p style="text-align: center; font: normal 8pt Tahoma; color: #00a0c0; text-decoration: none;">'.$caption.'<br>');
if ($date) {
echo('('.$date.')');
}
echo('</p>
<p style="text-align: right; font: normal 8pt Tahoma; color: #00a0c0; text-decoration: none;"><b>&copy; 2002-'.date("Y",time()).' Peter Damer</b><br><b>www.railway.eu.org</b></p>
</body>');
}
?>
</html>