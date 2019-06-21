<template>
  <div id="marker-popup" class="marker-popup" v-show="isVisible">
    <b>{{markerData.title}}</b>
    <hr>{{markerData.brief_description}}<hr>
    <div class="btn-block">
      <span>
        <i class="fa fa-thumbs-up" @click="voteUp()">{{markerData.rating_good}}</i> &nbsp;
        <i class="fa fa-thumbs-down" @click="voteDown()">{{markerData.rating_bad}}</i>
      </span>
      <span class="pull-right">                 
        <a href="#" class="more-btn" @click="moreDetails()">детальнiше</a>
      </span>
    </div>
  </div>
</template>

<script>
  import Overlay from 'ol/Overlay.js';

  export default {
    inject: ['getMapElements'],
    
    mounted() {
      var self = this;

      self.getMapElements('map', function (map) {
        self.setMarkerPopupListener(map);
      });
    },

    data () {
      return {
        isVisible: false,
        markerData:{
          title:null,
          brief_description:null,
          rating_good:null,
          rating_bad:null
        }        
      }
    },

    methods: {
      setMarkerPopupListener(map){
        let self = this;
        let markerPopupEl = document.getElementById('marker-popup');

        let popup = new Overlay({
          element: markerPopupEl,
          positioning: 'bottom-right',
          stopEvent: false,
          offset: [0, -30]
        });
        map.addOverlay(popup);

        map.on('click', function(e) {
          let feature = map.forEachFeatureAtPixel(e.pixel,
            function(feature) {
              return feature;
          });

          let isClickedOnPopup = popup.element.contains(e.originalEvent.target);
          
          if (feature) {
            self.markerData = feature.getProperties();
            popup.setPosition(feature.getGeometry().getCoordinates());
            self.isVisible = true;
          } else if(!isClickedOnPopup) {
            self.isVisible = false;
          }
        });

        map.on('pointermove', function(e) {   
          let isMarker = map.hasFeatureAtPixel(e.pixel);
          document.body.style.cursor = isMarker ? 'pointer' : '';
        });     
      },      
      voteUp(){
        console.log('up');
      },
      voteDown(){
        console.log('down');
      },
      moreDetails(){
        this.$emit('more-details', this.markerData);
      }
    }  
  }
</script>