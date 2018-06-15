import "babel-polyfill";
import Vue from "vue/dist/vue.js";
import vueheader from "../header.vue";
import vuebody from "./searchbody.vue";
import vuefooter from "../footer.vue";

// import "../../assets/js/base.js";

import css from "../../assets/styles/main.less";

require("font-awesome/less/font-awesome.less");

new Vue({
  el: "#app",
  components: {
    vueheader,
    vuebody,
    vuefooter
  },
  data: {
    info: {}
  },
  created(){
    let el = document.getElementsByTagName('vuebody')[0];
    // console.log(el);
    let info = JSON.parse(el.innerHTML);
    this.info = info;
  }
})