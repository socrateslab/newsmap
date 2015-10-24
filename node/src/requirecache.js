var querystring=require('querystring');
var url=require('url');

exports.processRequest = function (request, response) {
    response.writeHead(200, { 'Content-Type': 'text/html' });
	var qs= querystring.parse(url.parse(request.url).query);
	if(qs.key){
		delete require.cache[qs.key];
	}
	response.write('<html><head></head><body>');
	for(var key in require.cache){
	    response.write('<a href="?key=' + key + '">' + key + '</a><br/>');
	}
	response.write('<a href="?">View</a><br/>');
	response.end('</body></html>');
}
