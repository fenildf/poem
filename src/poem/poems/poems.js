import Vue from "vue/dist/vue.js";
import vueheader from "../header.vue";
import vuefooter from "../footer.vue";
import vuebody from "./poemsbody.vue";

import css from "../../assets/styles/main.less";

require("font-awesome/less/font-awesome.less");

new Vue({
  el: '#app',
  components: {
    vueheader,
    vuebody,
    vuefooter
  }
})