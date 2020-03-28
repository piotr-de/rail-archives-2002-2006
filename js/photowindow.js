var nr=0;
function photo(image,title,caption,date) {
presentation=window.open('',nr,'left=50 top=50 width=800px height=600px toolbar=no location=yes directories=no status=no menubar=yes scrollbars=no resizable=yes');
presentation.document.write('<HTML><HEAD><TITLE>'+title+'</TITLE></head>');
presentation.document.write('<body style=\"margin: 0px; background-color: #024a75;\">');
presentation.document.write('<DIV style="text-align: center;"><a href=\"javascript:void(null);\" onclick=\"javascript:self.close();\"><img src='+image+' border="0"></A></DIV>');
presentation.document.write('<p style="text-align: center; font: normal 8pt Tahoma; color: #ff8000; text-decoration: none;">'+caption+'<br>'+date+'</p></BODY></HTML>');
presentation.focus();
nr=++nr;
}