import Vue from "vue/dist/vue.js";
import axios from "axios";
import css from "./assets/styles/main.less";

require("font-awesome/less/font-awesome.less");

import vueheader from "./poem/header.vue";
import vuefooter from "./poem/footer.vue";
import vuebody from "./poem/body.vue";

new Vue({
  el:"#app",
  components:{
    vueheader,
    vuebody,
    vuefooter
  }
});