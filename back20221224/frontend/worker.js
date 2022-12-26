function navigate() {
var url_string = window.location.href; // www.test.com?filename=test
var url = new URL(url_string);
var paramValue = url.searchParams.get("iframe_url");
document.getElementById("selector").src = paramValue;}