<template>
  <div>
    <span v-for="author in authors">{{author}}</span>
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
@border: lightgray;
  span {
    display: inline-block;
    background-color: @bgc3;
    padding: 3px;
    margin: 4px;
  }
</style>