<template>
  <div>
    <poem :poems="poems"></poem>
    <pages :totalPage="totalPage"  @topage="toPage" :curPage="curPage"></pages>
  </div>
</template>

<script>
import pages from "./pages.vue";
import poem from "../poem.vue";

import axios from "axios";

export default {
  props: {
    info: {
      type: Object,
      required: true
    }
  },
  data:function(){
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
      let url = encodeURI(encodeURI('./?name=' + this.name + '&p=' + this.curPage));
      let self = this;
      axios.get(url)
      .then(function(response) {
        // console.log(response);
        self.poems = response.data;
      })
    }
  },
  created(){
    // let el = document.getElementsByTagName('vuebody')[0];
    // let info = JSON.parse(el.innerText);
    this.totalPage = this.info.totalPage;
    this.poems = this.info.poems;
    this.name = this.info.name;
  },
  mounted(){
    // console.log(this);
    if("search-body" === this.$parent.$el.className){
      // console.log("search");
      return;
    }
    this.$el.style.display = '';
    this.$el.style.minHeight = document.documentElement.clientHeight - 70 + "px";
  }
}
</script>

<style lang = "less" scoped>
div {
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