<template>
  <div id="main">
    <Header/>
      <Home/>
    <div class="container">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
  import Header from './Header.vue';
  import Home from './Home.vue';

  export default {
    name:'main-app',
        components:{
        Header,
        Home
    }
  }
</script>
