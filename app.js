
var mymap = L.map('mapid').setView([-1.2571434, -78.6566384], 12);
let printPlugin;
L.mapbox.accessToken = 'pk.eyJ1IjoiZWR3aW5vcmxhbmRvIiwiYSI6ImNrNG5jMmh3czBxeTYza3F5a3pvNzRiMTAifQ.EO7KFWuuevdQhwwwQ8rxUA';

/*

var mapboxTiles = L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/streets-v11/tiles/{z}/{x}/{y}?access_token=' + L.mapbox.accessToken, {
    attribution: '© <a href="https://www.mapbox.com/feedback/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    tileSize: 512,
    zoomOffset: -1
}).addTo(mymap);*/


var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18,
    attribution: ' ',
    id: 'mapbox/streets-v11',
}).addTo(mymap);

L.control.scale().addTo(mymap);


 

// or, add to an existing map:
mymap.addControl(new L.Control.Fullscreen());

this.printPlugin = L.easyPrint({
    title: 'Mi botón para imprimir', 
    elementsToHide: 'p, h2, .leaflet-control-zoom'
}).addTo(mymap);

L.Control.boxzoom({ position:'topleft' }).addTo(mymap);

var options = {
    position: 'topleft',
    lengthUnit: {
        factor: 0.539956803,    //  from km to nm
        display: 'Nautical Miles',
        decimal: 2
    }
};
L.control.ruler(options).addTo(mymap);
 
mymap.setView(new L.LatLng(-0.754412314580493, -80.150422059634266), 8);
$(document).ready(function () { 
 
 
    $('#tvCapas').tree({
        onLoadSuccess: function(node, data){   
          
            for (let i = 0; i < data.length ; i++)            {
                for (let j = 0; j < data[i].children.length ; j++){                  
                    var url = data[i].children[j].imgstyle;
                   $('<style>.icono-Cantones {  background: url("'+url+'") no-repeat center center; </style>').appendTo('head');    
  
                }
            }  

          
        }
    });

 
});
function addLayes(node) {
    console.log(node);
    if (node.children) {

    }
    else {
        if (node.checked) {
            agregarCapa(node.wms, node.layer);
        }
        else {
            removerCapa(node.layer);
        }

    }

}
function agregarCapa(wms, capa) {
    /*  var wmsLayer = L.tileLayer.wms(wms, {
          layers: capa,
          transparent: true,
          format: 'image/png',
      }).addTo(mymap);*/

  var  layer=  L.tileLayer.betterWms(wms, {
        layers: capa,
        transparent: true,
        format: 'image/png'
    }).addTo(mymap);
/*
    var p1 = L.point(layer._crs.projection.bounds.min.x, layer._crs.projection.bounds.min.y);
    var p2 = L.point(layer._crs.projection.bounds.max.x, layer._crs.projection.bounds.max.y);
    var bounds = L.bounds(p1, p2);
    console.log(layer._crs.projection.bounds ); 
    console.log(layer._crs.projection.bounds.min.x ); 
    
    mymap.fitBounds(bounds);*/


}
function removerCapa(capa) {
    mymap.eachLayer(function (fn) {
        if (fn.options.layers && fn.options.layers == capa) {
            mymap.removeLayer(fn);
        }
    });
}
function callWS() {
    var response = $.ajax({
        type: "GET",
        url: this.URL + 'ows?service=wms&version=2.0.1&request=GetCapabilities',
        async: false
    }).responseText;
    //  console.log(response);

    var json = $.xml2json(response);
    console.log(json.Capability.Layer.Layer);

    for (let i = 0; i < json.Capability.Layer.Layer.length; i++)
        console.log(json.Capability.Layer.Layer[i].Name);

}

function doSearch(value) {
    console.log(value);

    $('#tvCapas').tree('doFilter', value);

    
}

function imprimir(){
    printPlugin.printMap('A4Portrait', 'MyFileName');
}

function filtarCQL(){
    
   var wmsLayer = new L.TileLayer.WMS('http://51.79.67.52:8080/geoserver/sil/wms?', {
        layers: 'sil:LocalidadesManabi',
        format: 'image/png',
        transparent: true,
        version: '1.3.0',
       // crs: L.CRS.EPSG4326,
     
        zoom: 16,
        // set deafult cql_filter
        cql_filter : "dpa_desloc='ANDIL'" 
    }).addTo(mymap);
 
 
   
 


}