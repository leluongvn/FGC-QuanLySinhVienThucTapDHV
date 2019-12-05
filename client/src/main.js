import Vue from 'vue'
import App from './App.vue'
import BootstrapVue from 'bootstrap-vue'
import VueRouter from 'vue-router'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import routes from './routes.js'

//vue resource
import VueResource from 'vue-resource'

// vuelidate
import Vuelidate from 'vuelidate'

//vue noty
import VueNoty from 'vuejs-noty'
import 'vuejs-noty/dist/vuejs-noty.css'

//vue modal
import VModal from 'vue-js-modal'

//vue execl
import VueExcelXlsx from "vue-excel-xlsx";

//vue VueCookie
import VueCookie from 'vue-cookie'

Vue.use(VueCookie);
Vue.use(VueRouter)
Vue.use(BootstrapVue)
Vue.use(VueResource)
Vue.use(Vuelidate)
Vue.use(VueNoty)
Vue.use(VModal)
Vue.use(VueExcelXlsx);

//custom api
Vue.http.options.root = "http://localhost:8000/";

// Vue.http.options.root = "http://192.168.1.56:8000/";

//router
const router = new VueRouter({
  routes
})

new Vue({
  el: '#app',
  render: h => h(App),
  router
})
