<template>
  <my-map :zoom="zoom" :center="center" :width="width" :height="height">
    <div v-for="marker in markersData">
      <my-marker :marker-data="marker"></my-marker>
    </div>
  </my-map>
</template>

<script>
  import MyMap from './openlayer/my-map.vue'
  import MyMarker from './openlayer/my-marker.vue'
  import MapService from '../services/MapService.js';

  export default {
    created: function() {
      this.setMapSize();
    },
    mounted: function () {
      this.fetchMarkers();
    },    
    data () {
      return { 
        zoom: 4,
        center: [55, 40],
        width: window.innerWidth,
        height: window.innerHeight,
        markersData: []
      }
    },

    methods: {
      setMapSize() {
        this.height = this.height - MapService.topIndent;
      },
      fetchMarkers() {
        var self = this;

        MapService.getAllObjects().then(function (response) {
          self.markersData = response.data;
        }).catch(function (error) {
          console.log(error);
        });    
      }
    },

    components: {
      MyMap,
      MyMarker
    }
  }
</script>