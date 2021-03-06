import "babel-polyfill";
import Vue from "vue/dist/vue.js";
// import fastclick from "fastclick";
import vueheader from "../header.vue";
import vuefooter from "../footer.vue";
import vuebody from "../author.vue";

// import "../../assets/js/base.js";

import css from "../../assets/styles/main.less";
import authorscss from "./styles/authors.less";

// require("font-awesome/less/font-awesome.less");

// fastclick.attach(document.body);

new Vue({
  el:"#app",
  components: {
    vueheader,
    vuebody,
    vuefooter
  },
  data: {
    authors:{}
  },
  created(){
    let el = document.getElementsByTagName("vuebody")[0];
    let authors = JSON.parse(el.innerText);
    this.authors = authors;
    // console.log(this);
  },
  mounted(){
    let el = document.getElementById("authors");
    el.style.display = "block";
    el.style.minHeight = document.documentElement.clientHeight - 70 + "px";
  }
})