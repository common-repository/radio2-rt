function setCookie(cookieName, value, exdays) {
	var exdate = new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var cookieValue = escape(value) + ((exdays == null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie = cookieName + "=" + cookieValue;
}
function getCookie(cookieName) {
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++) {
		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		x=x.replace(/^\s+|\s+$/g,"");
		if (x==cookieName) {
			return unescape(y);
		}
	}
}
function sendToLinkblog(description, link, title) {
	var linkBlogServer=getCookie("linkWeblogServerDomain");
	if (linkBlogServer===null || linkBlogServer=="" || linkBlogServer==undefined) {
		linkBlogServer=prompt("The domain of your linkblog server:","");
		if (linkBlogServer!=null && linkBlogServer!="") {
			setCookie("linkWeblogServerDomain",linkBlogServer,365);
		}
	}
	window.location = "http://" + linkBlogServer + "/?link=" + link + "&title=" + title + "&description=" + description;
}
function setLinkblogServer() {
	var server = getCookie("linkWeblogServerDomain");
	if (server == "null") {
		server = "";
	}
	var linkBlogServer = prompt("The domain of your linkblog server:", server);
	setCookie("linkWeblogServerDomain", linkBlogServer, 365);
}
