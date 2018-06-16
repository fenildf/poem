<template>
  <div id="article">
    <h1 class = "title">{{title}}</h1>
    <p class = "author">{{author}}</p>
    <p class = "content">{{content}}</p>
  </div>
</template>

<script>
  export default {
    data(){
      return {
        title:'',
        author:'',
        content:''
      }
    },
    created(){
      let el = document.getElementsByTagName("vuebody")[0];
      let text = el.innerText;
      let textObj = JSON.parse(text)[0];
      // console.log(text);
      // console.log(textObj);
      // console.log(this);
      this.title = textObj.d_title;
      this.author = textObj.d_author;
      this.content = textObj.d_poetry;
    },
    mounted(){
      let el = document.getElementById("article");
      el.style.display = "block";
      el.style.minHeight = document.documentElement.clientHeight - 70 + "px";
    }
  };
</script>

<style lang = "less" scoped>
@color: #4f4f4f;
#article {
  width: 900px;
  text-align: center;
  margin: auto;
  padding: 10px;
  box-sizing: border-box;
  line-height: 2em;
  .title {
    color: @color;
    padding-top: 20px;
  }
  .content {
    white-space: pre-wrap;
    line-height: 30px;
  }
}

@media screen and (max-width: 900px){
  #article {
    width: 100%;
  }
}
</style>