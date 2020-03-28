var nr=0;
function show(path) {
presentation=window.open(path,nr,'left=50 top=50 width=800 height=600 toolbar=no location=yes directories=no status=no menubar=yes scrollbars=no resizable=yes');
presentation.focus();
nr=++nr;
}