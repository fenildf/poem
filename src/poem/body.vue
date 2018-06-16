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
    axios.get("./?first_loaded=true")
    .then(function(response){
      // console.log(this);
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
    margin: 0 30px 0 0;
  }
  aside {
    flex: 3;
    border: 1px solid @border;
    height: 100%;
    
  }
}

@media screen and (max-width: 900px){
  .body {
    width: 100%;
  }
}

@media screen and (max-width: 500px){
  .body {
    text-align: center;
    display: block;
    .poems {
      margin: 0;
    }
  }
}
</style>
