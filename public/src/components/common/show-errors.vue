<template>
  <div class="error-txt" v-if="errors.length">
    <ul class="list-group list-group-flush">
      <li class="list-group-item" v-for="error in errors">{{error}}</li>
    </ul>
  </div>  
</template>

<script>
  export default {
    props: {
      errors: {
        type: Array,
        required: true
      }
    }
  }
</script>