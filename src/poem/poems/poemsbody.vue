<template>
  <div id = "poemsbody">
    <poem :poems="poems"></poem>
    <pages :totalPage="totalPage"  @topage="toPage" :curPage="curPage"></pages>
  </div>
</template>

<script>
import pages from "./pages.vue";
import poem from "../poem.vue";

import axios from "axios";

export default {
  data(){
    return {
      curPage: 1,
      totalPage: 1,
      poems: {},
      name: ''
    }
  },
  components: {
    pages,
    poem
  },
  methods: {
    toPage(direction){
      if(isNaN(Number(direction))){
        if('pre' === direction){
          if(1 === this.curPage){
            return;
          }
          this.curPage--;
        }else if('next' === direction){
          if(this.totalPage === this.curPage){
            return;
          }
          this.curPage++;
        }
      }else{
        direction = Math.floor(Number(direction));
        if(direction > this.totalPage || direction < 1 || direction === this.curPage){
          return;
        }
        this.curPage = direction;
      }
      // console.log(direction);
      let url = './?name=' + this.name + '&p=' + this.curPage;
      let self = this;
      axios.get(url)
      .then(function(response) {
        console.log(response);
        self.poems = response.data;
      })
    }
  },
  created(){
    let el = document.getElementsByTagName('vuebody')[0];
    let info = JSON.parse(el.innerText);
    this.totalPage = info.totalPage;
    this.poems = info.poems;
    this.name = info.name;
  },
  mounted(){
    let el = document.getElementById('poemsbody');
    el.style.display = 'block';
    el.style.minHeight = document.documentElement.clientHeight - 70 + "px";
  }
}
</script>

<style lang = "less">
#poemsbody {
  width: 900px;
  margin: 0 auto;
  text-align: center;
  padding-top: 30px;
  box-sizing: border-box;
  section {
    margin: 0 0 30px 0;
  }
}
</style>