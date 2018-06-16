<template>
  <header>
    <div class="header">
      <div class = "logo">
        <a href = "./"><i class = "iconfont icon-shici logo"></i></a>
      </div>
      <div class = "category">
        <a href = "./?name=all"><p>诗词</p></a>
        <a href = "./?allName"><p>作者</p></a>
      </div>
      <div class = "search"><input type="text" placeholder="作者/诗歌" v-model="keyword" @keyup.enter="search"><i class = "iconfont icon-search" @click="search"></i></div>
    </div>
  </header>
</template>

<script>
export default {
  data(){
    return {
      keyword:''
    }
  },
  methods: {
    search(){
      // q_al : 搜索全部，包括作者和诗歌
      window.location.href="./?name=q_al" + this.keyword;
    }
  }
}
</script>

<style lang="less">
@bgc1: #999;
@bgc2: brown;
@bgc3: antiquewhite;
@color: white;
@border: lightgray;
header {
  width: 100%;
  height: 40px;
  background-color: @bgc2;
  .header {
      width: 900px;
      height: 40px;
      margin: auto;
      overflow: hidden;
      font-family: 'Times New Roman', Times, serif;
      >div {
        float: left;
      }
      .logo {
        color: @color;
        height: 40px;
        line-height: 40px;
        font-size: 30px;
      }
      .category {
        margin-left: 100px;
        
        p {
          display: inline-block;
          font-size: 20px;
          line-height: 40px;
          color: @color;
          margin: 0 20px;
        }
      }
      .search {
        float: right;
        line-height: 30px;
        width: 200px;
        margin-top: 5px;
        border-radius: 15px;
        background-color: @color;
        overflow: hidden;
        input {
          border: none;
          outline: none;
          -webkit-appearance: none;
          width: 170px;
          height: 20px;
          box-sizing: border-box;
          padding: 0;
          padding-left: 15px;
        }
        i {
          cursor: pointer;
        }
      }
    }
}

</style>
