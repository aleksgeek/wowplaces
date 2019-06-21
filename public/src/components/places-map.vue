<template>
  <my-map :zoom="zoom" :center="center" :width="width" :height="height">
    <div v-for="marker in markersData">
      <my-marker :marker-data="marker"></my-marker>
    </div>
    <my-marker-popup @more-details="showMarkerDetailWindow"></my-marker-popup>
    <my-marker-details v-if="isMarkerDetailVisible" @close="closeMarkerDetailWindow()" :marker-data="selectedMarkerData" :width="width" :height="height"></my-marker-details>
  </my-map>
</template>

<script>
  import MyMap from './openlayer/my-map.vue'
  import MyMarker from './openlayer/my-marker.vue'
  import MapService from '../services/MapService.js';
  import MyMarkerPopup from './openlayer/my-marker-popup.vue';
  import MyMarkerDetails from './openlayer/my-marker-details.vue';

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
        center: [30.5234, 50.4501],
        width: window.innerWidth,
        height: window.innerHeight,
        markersData: [],
        isMarkerDetailVisible:false,
        selectedMarkerData:{}
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
      },
      showMarkerDetailWindow(markerData){
        this.selectedMarkerData = markerData;
        this.isMarkerDetailVisible = true;
      },
      closeMarkerDetailWindow(){
        this.isMarkerDetailVisible = false;
      }      
    },

    components: {
      MyMap,
      MyMarker,
      MyMarkerPopup,
      MyMarkerDetails
    }
  }
</script>