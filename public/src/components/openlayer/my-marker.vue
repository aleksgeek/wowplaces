<template></template>

<script>
  import Feature from 'ol/Feature.js';
  import View from 'ol/View.js';
  import Point from 'ol/geom/Point.js';  
  import {Tile as TileLayer, Vector as VectorLayer} from 'ol/layer.js';
  import {Icon, Style} from 'ol/style.js';
  import Overlay from 'ol/Overlay.js';

  export default {
    inject: ['getMapElements'],
    
    mounted: function () {
      var self = this;

      self.getMapElements('vectorLayer', function (vectorLayer) {
        self.setMarker(vectorLayer);
      });
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
        markerHeight:30
      }
    },

    methods: {
      setMarker(vectorLayer){
        ///vectorLayer.getSource().clear();
        var self = this;

        var iconFeature = new Feature({
          geometry: new Point(ol.proj.transform([parseFloat(self.markerData.longitude), parseFloat(self.markerData.latitude)], 'EPSG:4326', 'EPSG:3857')),
          id: self.markerData.id,
          title: self.markerData.title,
          brief_description: self.markerData.brief_description,
          description: self.markerData.description, 
          rating_good: self.markerData.rating_good, 
          rating_bad: self.markerData.rating_bad,
          height: self.markerHeight
        });
        
        if('default' == self.iconStyle){
          var iconStyle = self.getDefaultIconStyle();
        }

        iconFeature.setStyle(iconStyle);
        vectorLayer.getSource().addFeature(iconFeature);
      },
      getDefaultIconStyle(){
        let iconStyle = new Style({
          image: new  Icon(({
            anchor: [0.5, this.markerHeight],
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