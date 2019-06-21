<template>
  <div>
    <div id="map" class="map" :style="{width: width+'px', height:height+'px'}">
      <slot></slot>
    </div>
  </div>  
</template>

<script>
  import Map from 'ol/Map.js';
  import View from 'ol/View.js';
  import Point from 'ol/geom/Point.js';
  import {Tile as TileLayer, Vector as VectorLayer} from 'ol/layer.js';
  import VectorSource from 'ol/source/Vector.js';

  export default {
    provide: function () {
      return {
        getMapElements: this.getMapElements
      }
    },

    mounted() {
      this.generateMap();
    },

    props: {
      zoom: {
        type: Number,
        required: false,
        default: 3
      },
      center: {
        type: Array,
        required: false,
        default: [0, 0]
      },
      width: {
        type: Number,
        required: true
      },
      height: {
        type: Number,
        required: true
      }     
    },

    data () {
      return {
        vectorLayer:null,
        map:null
      }
    },

    methods: {
      getMapElements: function (element, foundElement) {
        var self = this;

        function checkForElement() {
          if (self[element]) {
            foundElement(self[element])
          } else {
            setTimeout(checkForElement, 100);
          }
        }
        checkForElement();
      },
      generateMap() {
        var self = this;
        
        var vectorSource = new ol.source.Vector({
          features: []
        });

        self.vectorLayer = new ol.layer.Vector({
          source: vectorSource
        });

        self.map = new Map({
          target: 'map',
          layers: [
            new ol.layer.Tile({
              source: new ol.source.OSM()
            }), 
            self.vectorLayer
          ],
          view: new ol.View({
            center: ol.proj.fromLonLat(self.center),
            zoom: self.zoom,
            minZoom: 2,
          })
        });
      }
    }      
  }
</script>