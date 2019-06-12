<template></template>

<script>
  import Feature from 'ol/Feature.js';
  import View from 'ol/View.js';
  import Point from 'ol/geom/Point.js';  
  import {Tile as TileLayer, Vector as VectorLayer} from 'ol/layer.js';
  import {Icon, Style} from 'ol/style.js';

  export default {
    inject: ['getVectorLayer'],   
    mounted: function () {
      var vm = this;

      this.getVectorLayer(function (vectorLayer) {
        vm.setMarker(vectorLayer);
      })
    },

    props: {
      markerData: {
        type: Object,
        required: true
      },
      iconStyle: {
        type: String,
        required: false,
        default: 'default'        
      }   
    },

    data () {
      return {
      }
    },

    methods: {
      setMarker(vectorLayer){
        ///vectorLayer.getSource().clear();
        var self = this;

        var iconFeature = new Feature({
          geometry: new Point(ol.proj.transform([parseFloat(self.markerData.longitude), parseFloat(self.markerData.latitude)], 'EPSG:4326', 'EPSG:3857')),
          name: self.markerData.title,
        });
        
        if('default' == self.iconStyle){
          var iconStyle = self.getDefaultIconStyle();
        }

        iconFeature.setStyle(iconStyle);
        vectorLayer.getSource().addFeature(iconFeature);
      },
      getDefaultIconStyle(){
        var iconStyle = new Style({
          image: new  Icon(({
            anchor: [0.5, 30],
            anchorXUnits: 'fraction',
            anchorYUnits: 'pixels',
            opacity: 0.75,
            src: '/img/marker_s.png'
          }))
        });

        return iconStyle;
      }
    }  
  }
</script>