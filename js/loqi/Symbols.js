define([
  "dojo/_base/declare",
  "dojo/_base/array"
], function(declare, array){
return declare("loqi.SymbolLibrary", [], {
    colors: ["blue", "orange", "red", "yellow", "green", "purple", "gray", "pink"],
    types: ["dot-large", "dot-small", "marker-large", "marker-small", "handle"],
    subtypes: {
      "dot-large": ["blank"],
      "dot-small": ["blank"],
      "marker-large": ["blank", "cutout", "user", "message"],
      "marker-small": ["blank", "cutout", "user", "message"],
      "handle": ["arrows"]
    },
    dimensions: {
      "dot-large": {
        width: 19 * 0.75,
        height: 19 * 0.75,
        xoffset: 0,
        yoffset: 0
      },
      "dot-small": {
        width: 13 * 0.75,
        height: 13 * 0.75,
        xoffset: 0,
        yoffset: 0
      },
      "marker-large": {
        width: 39 * 0.75,
        height: 50 * 0.75,
        xoffset: 0,
        yoffset: (50*0.75/2) - 7
      },
      "marker-small": {
        width: 31 * 0.75,
        height: 43 * 0.75,
        xoffset: 0,
        yoffset: (43*0.75/2) - 5
      },
      "handle": {
        width: 25 * 0.75,
        height: 25 * 0.75,
        xoffset: 0,
        yoffset: 0
      }
    },
    symbols: {},
    constructor: function(basePath) {
      array.forEach(this.types, dojo.hitch(this, function(type){
        array.forEach(this.colors, dojo.hitch(this, function(color){
          array.forEach(this.subtypes[type], dojo.hitch(this, function(subtype){
            var key = type +"-"+ color +"-"+ subtype;
            this.symbols[key] = {
              "type" : "esriPMS",
              "url" : basePath + "/" + key + ".png",
              "contentType" : "image/png",
              "width" : this.dimensions[type].width,
              "height" : this.dimensions[type].height,
              "xoffset" : this.dimensions[type].xoffset,
              "yoffset" : this.dimensions[type].yoffset
            };
          }));
        }));
      }));
    },
    get: function(key){
      return new esri.symbol.PictureMarkerSymbol(this.symbols[key]);
    }
  });
});