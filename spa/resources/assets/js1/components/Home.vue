<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-default">
          <div class="card-header">Vue.js SPA example</div>
          <div class="card-body">
            <h2>{{ welcome }}</h2>
            <img src="images/som.jpg" alt="" class="w-100 h-100 p-0 m-0">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'Home',
    computed: {
      welcome() {
        return this.$store.getters.welcome
      }
    }
  }
</script>

<style>

</style>
