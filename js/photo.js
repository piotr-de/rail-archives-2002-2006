var nr=0;
function photo(image,width,height,title) {
presentation=window.open('',nr,'left=50 top=50 width='+width+'px height='+height+'px innerheight='+height+'px innerwidth='+width+'px toolbar=no location=no directories=no status=no menubar=no scrollbars=no resizable=yes');
presentation.document.write('<HTML><HEAD><TITLE>'+title+'</TITLE>');
presentation.document.write('<script language="JavaScript" type="text/javascript">');
presentation.document.write('setTimeout("self.close()",120000)</script></HEAD>');
presentation.document.write('<body style=\"margin: 0px; background-color: white;\">');
presentation.document.write('<DIV style="text-align: center;"><a href=\"javascript:void(null);\" onclick=\"javascript:self.close();\"><img src='+image+' border="0"></A></DIV>');
presentation.document.write('</BODY></HTML>');
presentation.focus();
nr=++nr;
}