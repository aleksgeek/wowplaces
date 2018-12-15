<template>
  <div>
    <top-menu></top-menu>
    <router-view></router-view>
  </div>
</template>

<script>
  import TopMenu from './top-menu.vue';

  export default {
    components: {
      'top-menu': TopMenu
    }
  }
</script>