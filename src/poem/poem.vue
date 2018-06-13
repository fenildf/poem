<template>
  <div id = "poems">
    <section v-for="poem in poems">
      <a :href = "'./?id='+poem.ID" target="_blank"><h1>{{poem.d_title}}</h1></a>
      <p>{{poem.d_author}}</p>
      <p class = "text">{{poem.d_poetry}}</p>
    </section>
  </div>
</template>

<script>
export default {
  props:{
    poems:{
      type:Object,
      required:true
    }
  }
}
</script>

<style lang="less">
@bgc1: #999;
@bgc2: brown;
@bgc3: antiquewhite;
@color: white;
@color2: #4f4f4f;
@border: lightgray;
  section {
    padding: 10px;
    box-sizing: border-box;
    border:1px solid @border;
    margin: 0 30px 30px 0;
    background-color: @bgc3;
    h1 {
      color: @color2;
      display: inline-block;
    }
    .text {
      white-space: pre-wrap;
      line-height: 20px;
      max-height: 100px;
      overflow: hidden;
    }
  }
</style>