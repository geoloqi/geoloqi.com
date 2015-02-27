define([
  "dojo/_base/declare",
  "dojo/_base/lang"
], function(declare, lang){
  return declare("loqi.Movie", null, {
    // symbols
    pointSymbol: null,
    userSymbol: null,
    lineSymbol: null,
    polygonSymbol: null,
    highlightSymbol: null,
    // map and data
    map: null,
    path: null,
    triggers: null,

    // internal use...
    _points: null,
    _geom: null,
    _lineGraphic: null,
    _circles: [], // array of graphics
    _triggerPoints: [], // array of graphics

    constructor: function(args) {
      dojo.mixin(this, args);
      this.layers = {
        line: new esri.layers.GraphicsLayer(),
        markers: new esri.layers.GraphicsLayer(),
        circles: new esri.layers.GraphicsLayer(),
        user: new esri.layers.GraphicsLayer()
      };

      this.map.addLayer(this.layers.circles);
      this.map.addLayer(this.layers.line);
      this.map.addLayer(this.layers.markers);
      this.map.addLayer(this.layers.user);


      dojo.forEach(this.triggers, function(trigger, index) {
        point = esri.geometry.geographicToWebMercator(new esri.geometry.Point(trigger.ll[1], trigger.ll[0], new esri.SpatialReference({ "wkid": 4326 })));
        
        var sp = this.map.toScreen(point);
        sp.x -= 154;
        sp.y -= 125;
        console.log(sp);
        var container = dojo.create("div", {
          "id": "popup" + index,
          "class": "map-popup",
          "style": {
            "display": "none",
            "background": "url(/img/popup.png) transparent",
            "left": (sp.x) + "px",
            "height": "86px",
            "position": "absolute",
            "top": (sp.y) + "px",
            "width": "311px",
            "zIndex": "40"
          }
        });
        dojo.create("img", {
          "src": trigger.attributes.icon,
          "style": {
            "float": "left",
            "margin": "18px 0 0 12px"
          }
        }, container);
        var contentContainer = dojo.create("div", {
          "style": {
            "padding": "4px 6px 4px 41px"
          }
        }, container);
        dojo.create("h6", {
          "innerHTML": trigger.attributes.title,
          "style": {
            "fontSize": "14px",
            "fontFamily": "Helvetica, Arial, sans-serif",
            "margin": "0",
            "color": "white",
            "lineHeight": "1.5em"
          }
        }, contentContainer);
        dojo.create("p", {
          "innerHTML": trigger.attributes.message,
          "style": {
            "fontSize": "12px",
            "fontFamily": "Helvetica, Arial, sans-serif",
            "color": "white",
            "margin": "0",
            "lineHeight": "1.25em"
          }
        }, contentContainer);

        dojo.place(container, this.map.root);
      });

      this._createDemoPath();
      this._addTriggerPoints();

    },

    // call when map.onLoad fires
    play: function() {
      
      this._animate();
    },

    _createDemoPath: function() {
      // flip lat, long to long, lat to play nice with esri.geometry.Polyline
      var longLats = dojo.map(this.path, function(latLong) {
        return [latLong[1], latLong[0]];
      });
      var line = new esri.geometry.Polyline(new esri.SpatialReference({wkid:4326}));
      line.addPath(longLats);
      // convert to web mercator
      this._geom = esri.geometry.geographicToWebMercator(line);

      // add a graphic with an empty geometry for the path
      // adding now so it shows up under the points m are added later
      var emptyLine = new esri.geometry.Polyline(this._geom.spatialReference);
      emptyLine.addPath([]);
      this._lineGraphic = new esri.Graphic(emptyLine, this.lineSymbol);
      this.layers.line.add(this._lineGraphic);
    },

    _addTriggerPoints: function() {
      dojo.forEach(this.triggers, function(t, idx) {
        var geom = new esri.geometry.Point(t.ll[1], t.ll[0], new esri.SpatialReference({ "wkid": 4326 }));
        var merc = esri.geometry.geographicToWebMercator(geom);
        // add the circles first so points appear on top of them
        this._buildCircle(merc, 350);
        this._triggerPoints.push(new esri.Graphic(merc, this.pointSymbol, t.attributes));
        this.layers.markers.add(this._triggerPoints[idx]);
        // show a circle around each point
      }, this);
    },

    _animate: function() {
      // reference to the points used to move the marker/extend line
      var points = this._geom.paths[0];
      // add the first point
      var lg = this._lineGraphic;
      lg.setGeometry(lg.geometry.insertPoint(0, 0, new esri.geometry.Point(points[0], this.map.spatialReference)));
      // keep track of where we're at in the array of points
      var idx = 1;
      // add a graphic with the orange geoloqi symbol
      var userGeom = new esri.geometry.Point(points[0], this.map.spatialReference);

      var graphic = new esri.Graphic(userGeom, this.userSymbol);
      this.layers.user.add(graphic);

      // use setInterval to move the orange user graphic and animate the line
      // also change circle color as the point passes by
      //
      // use dojo.partial to provide "this" to the function
      // that animates the point and path
      var timer = setInterval(dojo.partial(function(m) {
        if ( idx < points.length ) {
          var newPoint = new esri.geometry.Point(points[idx], map.spatialReference);
          graphic.setGeometry(newPoint);
          var newLine = lg.geometry.insertPoint(0, idx, newPoint);
          lg.setGeometry(newLine);
          idx++;
          // index numbers lifted from https://geoloqi.com/assets/home_page.269258.js
          switch (idx) {
            case 20:
              m._circles[0].setSymbol(m.highlightSymbol);
              m._showPopup(m._triggerPoints[0], 1);
              break;
            case 88:
              m._circles[1].setSymbol(m.highlightSymbol);
              m._showPopup(m._triggerPoints[1], 2);
              break;
            case 134:
              m._circles[2].setSymbol(m.highlightSymbol);
              m._showPopup(m._triggerPoints[2], 3);
              break;
            case 207:
              m._circles[3].setSymbol(m.highlightSymbol);
              m._showPopup(m._triggerPoints[3], 4);
              break;
            case 247:
              m._circles[4].setSymbol(m.highlightSymbol);
              m._showPopup(m._triggerPoints[4], 5);
              break;
            case 292:
              $("#leading-wrapper").addClass("finished");
              setTimeout(function(){
                $(".push-notification").hasClass("hide");
              }, 1000);
              break;
          }
        } else {
          clearInterval(timer);
        }
      }, this), 45);
    },

    _buildCircle: function(center, radius) {
      var circle = new esri.geometry.Polygon(this.map.spatialReference);
      var numPts = 60;
      var angle = (2 * Math.PI) / numPts;
      var pts = [];
      for (i = 0; i < numPts; i++) {
        pts.push([center.x + radius * Math.cos(angle * i), center.y + radius * Math.sin(angle * i)]);
      }
      // close the polygon
      pts.push(pts[0]);
      circle.addRing(pts);
      var circleSymbol = new esri.symbol.SimpleFillSymbol(this.polygonSymbol.toJson())
        .setOutline(new esri.symbol.SimpleLineSymbol(this.lineSymbol.toJson()).setWidth(1));
      var graphic = new esri.Graphic(circle, circleSymbol);
      this.layers.circles.add(graphic);
      this._circles.push(graphic);
    },

    _showPopup: function(graphic, push) {
      $("#popup"+(push-1)).show();
      $(".push-notification", "#demo-phone").html("<img src='"+graphic.attributes.icon+"'><div><h4>"+graphic.attributes.title+"</h4><p>"+graphic.attributes.breaks+"</p></div></div>").removeClass("hide");
      $("#demo-phone").addClass("shake");
    }
  });
});