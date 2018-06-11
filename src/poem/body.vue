<template>
  <div class="body" id="body">
    <div class="poems">
      <poem :poems="poems"></poem>
    </div>
    <aside>
      <author :authors="authors"></author>
    </aside>
  </div>
</template>

<script>
import poem from "./poem.vue";
import author from "./author.vue";

import axios from "axios";

export default {
  data(){
    return {
      poems:{},
      authors:{}
    }
  },
  components:{
    poem,
    author
  },
  created(){
    var self = this;
    axios.get("./quest?first_loaded=true")
    .then(function(response){
      console.log(this);
      self.poems = response.data.poems;
      console.log(response.data.poems);
      self.authors = response.data.authors;
    })
    .catch(function(error){
      console.log(error);
    })
  }
}
</script>


<style lang="less" scoped>
@bgc1: #999;
@bgc2: brown;
@bgc3: antiquewhite;
@color: white;
@border: lightgray;
.body {
    width: 900px;
    margin: auto;
    box-sizing: border-box;
    padding: 10px;
    display: flex;
    .poems, sidebar {
      min-height: 50px;
    }
    .poems {
      flex: 7;
    }
    aside {
      flex: 3;
      border: 1px solid @border;
      height: 100%;
      
    }
  }
</style>
