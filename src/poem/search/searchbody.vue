<template>
  <div class = "search-body">
    <div class = "tabs">
      <div v-for="item in items" :class="['tab-button',{active: item.title === curTab}]" @click="curTab = item.title">{{item.title}}</div>
    </div>
    <div>
      <poemlist v-for="item in items" :info="item.info" :key="item.title" v-show="item.title === curTab"></poemlist>
    </div>
  </div>
</template>

<script>
import poemlist from "../poems/poemsbody.vue";

export default {
  props: {
    info: {
      type: Object,
      required: true
    }
  },
  components: {
    poemlist
  },
  data(){
    return {
      items: {
        author: {
          title: "作者",
          info: {}
        },
        poetry: {
          title: "诗词",
          info: {}
        },
        title: {
          title: "标题",
          info: {}
        }
      },
      curTab: "作者"
    }
  },
  created(){
    // console.log(this);
    
    this.info.poetry.poems
    this.items.author.info = this.info.author;
    this.items.poetry.info = this.info.poetry;
    this.items.title.info = this.info.title;
  },
  mounted(){
    this.$el.style.display="";
    this.$el.style.minHeight = document.documentElement.clientHeight - 70 + "px";
  }
}
</script>

<style lang = "less" scoped>
@bgc: antiquewhite;
@border: white;
@border2: lightgray;
.search-body {
  width: 900px;
  margin: 0 auto;
  .tabs {
    text-align: left;
    padding-top: 30px;
    margin-bottom: -60px;
    >.tab-button {
      display: inline-block;
      width: 50px;
      height: 20px;
      line-height: 20px;
      text-align: center;
      background-color: @bgc;
      cursor: pointer;
      border: 1px solid @border;
      border-bottom: 0px;
      &.active {
        width: 56px;
        height: 24px;
        font-size: 20px;
        line-height: 24px;
        border-color: @border2;
      }
    }
  }
}

</style>