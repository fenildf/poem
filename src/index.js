import "babel-polyfill";
import Vue from "vue/dist/vue.js";
// import fastclick from "fastclick";
import axios from "axios";
import css from "./assets/styles/main.less";

// import "./assets/js/base.js";

// require("font-awesome/less/font-awesome.less");

import vueheader from "./poem/header.vue";
import vuefooter from "./poem/footer.vue";
import vuebody from "./poem/body.vue";

// fastclick.attach(document.body);

new Vue({
  el:"#app",
  components:{
    vueheader,
    vuebody,
    vuefooter
  }
});