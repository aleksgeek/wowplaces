<template>
  <div class="main-content">
    <vl-map :load-tiles-while-animating="true" :load-tiles-while-interacting="true" v-bind:style="{ width: width + 'px', height: height + 'px' }">
      <vl-view :zoom.sync="zoom" :center.sync="center" :rotation.sync="rotation"></vl-view>

        <vl-layer-tile id="osm">
            <vl-source-osm></vl-source-osm>
        </vl-layer-tile>

        <vl-feature :properties="{prop: 'value', prop2: 'value'}">
            <vl-geom-point :coordinates="[0, 0]"></vl-geom-point>
        </vl-feature>
    </vl-map>
  </div>
</template>

<script>
  export default {
    mounted() {
      this.setMap();
    },

    data () {
      return { 
        zoom: 2,
        center: [0, 0],
        rotation: 0,
        geolocPosition: undefined,
        width: window.innerWidth,
        height: 0
      }
    },

    methods: {
      setMap() {
        /// TODO
        var mapElement = document.getElementById('map');
        this.height = window.innerHeight - 30;                   
      }
    }
  }
</script>