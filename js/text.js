var nr=0;
function text(src,width,height,title) {
presentation=window.open(src,nr,'left=50 top=50 width='+width+'px height='+height+'px innerheight='+height+'px innerwidth='+width+'px toolbar=no location=no directories=no status=no menubar=no scrollbars=1 resizable=no');
presentation.focus();
nr=++nr;
}