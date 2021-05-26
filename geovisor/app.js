
var mymap = L.map('mapid').setView([-1.2571434, -78.6566384], 12);

L.mapbox.accessToken = 'pk.eyJ1IjoiZWR3aW5vcmxhbmRvIiwiYSI6ImNrNG5jMmh3czBxeTYza3F5a3pvNzRiMTAifQ.EO7KFWuuevdQhwwwQ8rxUA';


var mapboxTiles = L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/streets-v11/tiles/{z}/{x}/{y}?access_token=' + L.mapbox.accessToken, {
    attribution: '© <a href="https://www.mapbox.com/feedback/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    tileSize: 512,
    zoomOffset: -1
}).addTo(mymap);


var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18,
    attribution: ' ',
    id: 'mapbox/streets-v11',
}).addTo(mymap);

L.control.scale().addTo(mymap);


var options = {
    position: 'topleft',
    lengthUnit: {
        factor: 0.539956803,    //  from km to nm
        display: 'Nautical Miles',
        decimal: 2
    }
};
L.control.ruler(options).addTo(mymap);


$(document).ready(function () {
    //   callWS();


    /*$("input").click(function (event) {

        let layerClicked = window[event.target.value];
        console.log(layerClicked);
        mymap.removeLayer(layerClicked);
        mymap.addLayer(layerClicked);

    });*/






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

    L.tileLayer.betterWms(wms, {
        layers: capa,
        transparent: true,
        format: 'image/png'
    }).addTo(mymap);

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