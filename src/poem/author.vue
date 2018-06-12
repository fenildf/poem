<template>
  <div>
    <a :href = "'./?name='+author" target="_blank" v-for="author in authors"><span>{{author}}</span></a>
  </div>
</template>

<script>
export default {
  props:{
    authors:{
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
@color2: black;
@border: white;
  span {
    display: inline-block;
    background-color: @bgc3;
    padding: 3px;
    margin: 4px;
    color: @color2;
    border: 1px solid @border;
  }
</style>