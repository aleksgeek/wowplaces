<template>
    <transition name="slide-fade">
      <div id="marker-details" class="marker-details" :style="{width: width+'px', height:height+'px'}">
        <div class="pointer right-txt">
          <i class="fa fa-close" @click="closeMarkerDetails()"></i>
        </div>
        <div class="title">{{markerData.title}}</div>
        <hr>
        <div class="body">{{markerData.description}}</div>
      </div>
    </transition>
</template>

<script>
  export default {
    props: {
      markerData: {
        type: Object,
        required: true
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
      }
    },

    methods: {
      closeMarkerDetails(){
        this.$emit('close');
      }
    }  
  }
</script>