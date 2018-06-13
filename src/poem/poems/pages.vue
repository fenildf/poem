<template>
  <div id = "pages">
    <span :class = "[buttonClass,cCurPage <= 1 ? '' : readyClass]" @click="page('pre')">&lt;</span>
    <input type="number" v-model="tempCurPage" @keyup.enter="page(cCurPage)" min="1" :max="cTotalPage">
    <span>/{{totalPage}}</span>
    <span :class = "[buttonClass,cCurPage >= cTotalPage ? '' : readyClass]" @click="page('next')">&gt;</span>
  </div>
</template>

<script>
  export default {
    props: {
      totalPage: {
        type: Number,
        required: true
      },
      curPage: {
        type: Number,
        required: true
      }
    },
    data(){
      return {
        buttonClass: 'button',
        readyClass: 'ready',
        tempCurPage: null
      }
    },
    computed: {
      cTotalPage: function(){
        return this.totalPage;
        // console.log(this);
      },
      cCurPage: function(){
          // console.log(this);
          // console.log(this.tempCurPage);
          if(this.tempCurPage < 1){
            this.tempCurPage = 1;
          }else if(this.tempCurPage > this.totalPage){
            this.tempCurPage = this.totalPage;
          }
          return this.tempCurPage;
        }
    },
    methods: {
      page: function(direction){
        // console.log(direction);
        if(isNaN(Number(direction)) && direction != 'next' && direction != 'pre'){
          // console.log(direction);
          return;
        }
        // console.log(direction);
        this.$emit('topage',direction);
      },
      changeTempCurPage: function(val){
        this.tempCurPage = val;
      }
    },
    watch: {
      curPage: 'changeTempCurPage'
    }
  }
</script>

<style lang="less" >
@bgc: #eee;
@bgc2: #ddd;
@border: lightgray;
#pages {
  font-size: 16px;
  padding-bottom: 30px;
  * {
    display: inline-block;
    height: 34px;
    line-height: 30px;
    box-sizing: border-box;
    vertical-align: bottom;
  }
  input {
    width: 40px;
    padding-bottom: 0px;
    text-align: center;
  }
  .button {
    cursor: pointer;
    width: 80px;
    background-color: @bgc;
    border: 1px solid @border;
    
  }
  .ready:hover {
    background-color: @bgc2;
  }
}
</style>