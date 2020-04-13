import Vue from 'vue'
import App from './App.vue'
import config from '../app.config'
import routes from './router/routes.js'
import 'bootstrap/dist/css/bootstrap.css'
import './main.scss'
import store from './store'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import RouterService from './services/router.service'
import {ApiAxios} from "./services/axios.service";

// Install BootstrapVue
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);

Vue.config.productionTip = false;

RouterService.init(routes);
ApiAxios.init(config.ApiBaseUrl);

new Vue({
  router : RouterService.getRouter(),
  store,
  render: h => h(App)
}).$mount('#app');
