import Vue from "vue/dist/vue.js";
import axios from "axios";
import css from "./assets/styles/main.less";

Vue.component('poem',{
  props:['poems'],
  template:`
    <div>
      <section v-for="poem in poems">
        <h1>{{poem.d_title}}</h1>
        <p>{{poem.d_author}}</p>
        <p class = "text">{{poem.d_poetry}}</p>
      </section>
    </div>
  `
});

Vue.component('author',{
  props:['authors'],
  template:`
    <div>
      <span v-for="author in authors">{{author}}</span>
    </div>
  `
});

var v = new Vue({
  el:"#body",
  data:{
    poems:{},
    authors:{}
  },
  created(){
    var self = this;
    axios.get("./quest?first_loaded=true")
    .then(function(response){
      console.log(this);
      self.poems = response.data.poems;
      console.log(response.data.poems);
      self.authors = response.data.authors;
    })
    .catch(function(error){
      console.log(error);
    })
  }
})