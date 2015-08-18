(function(){
	var i = 0;
	var elements = document.getElementsByTagName("a");
	while(element = elements[i++]) {
		classNameParts = element.className.split(" ");
		if(classNameParts){
			var isGeoloqiMap = false;
			var isGeoloqiLayer = false;
			
			var geoloqiWidgetHeight = false;
			var geoloqiWidgetWidth = false;
			var geoloqiMapWidgetHeight = 200;
			var geoloqiMapWidgetWidth = "100%";
			var geoloqiLayerWidgetHeight = 30;
			var geoloqiLayerWidgetWidth = 90;
			
			var geoloqiQueryString = "embed=" + encodeURIComponent(window.location);
			
			if(document.referrer) {
				geoloqiQueryString += "&referer=" + encodeURIComponent(document.referrer);
			}
			
			for(var j=0; j<classNameParts.length; j++) {
				if(classNameParts[j] == "geoloqi-follow-map") {
					isGeoloqiMap = true;
				} else if(classNameParts[j] == "geoloqi-subscribe-layer") {
					isGeoloqiLayer = true;
				}
				if(match = classNameParts[j].match(/geoloqi-height-([0-9%]+)/)) {
					geoloqiWidgetHeight = match[1];
				}
				if(match = classNameParts[j].match(/geoloqi-width-([0-9%]+)/)) {
					geoloqiWidgetWidth = match[1];
				}
				if(match = classNameParts[j].match(/geoloqi-(light|dark)/)) {
					geoloqiQueryString += "&theme=" + match[1];
				}
			}
			var iframeSrc;
			if(isGeoloqiMap) {
				if(geoloqiWidgetHeight == false) {
					geoloqiWidgetHeight = geoloqiMapWidgetHeight;
				}
				if(geoloqiWidgetWidth == false) {
					geoloqiWidgetWidth = geoloqiMapWidgetWidth;
				}
				iframeSrc = elements[i-1].href.replace(/https?:\/\/[a-zA-Z\.]+\/([a-zA-Z0-9_]+\/[a-zA-Z0-9_]+)/, 'http://geoloqi.com/trip/widget/$1');
			} else if(isGeoloqiLayer) {
				geoloqiWidgetHeight = 24;
				geoloqiWidgetWidth = 180;
				iframeSrc = elements[i-1].href.replace(/https?:\/\/[a-zA-Z\.]+\/layer\/(?:info\/)?([a-zA-Z0-9_]+)/, 'http://geoloqi.com/layer/$1/widget');
			}
			if(isGeoloqiMap || isGeoloqiLayer) {
				elements[i-1].innerHTML = '<iframe frameborder="0" border="0" scrolling="no" width="' + geoloqiWidgetWidth + '" height="' + geoloqiWidgetHeight + '" src="' + iframeSrc + '?' + geoloqiQueryString + '"></iframe>';
			}
		}
	}
})();
