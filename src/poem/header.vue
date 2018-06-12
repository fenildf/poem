<template>
  <header>
    <div class="header">
      <div class = "logo">
        <a href = "./"><h2>Poem</h2></a>
      </div>
      <div class = "category">
        <a href = "javascript:void(0);"><p>诗词</p></a>
        <a href = "./?allName"><p>作者</p></a>
      </div>
      <div class = "search"><input type="text"><i class = "fa fa-search"></i></div>
    </div>
  </header>
</template>

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
      h2 {
        color: @color;
        height: 40px;
        line-height: 40px;
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
