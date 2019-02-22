import './bootstrap'

import Vue from 'vue'
window.Vue = Vue

//===========Vuex==========================================
import Vuex from 'vuex'
Vue.use(Vuex)

//==========Vuetify========================================
import Vuetify from 'vuetify'
// Импорт CSS-файлов, которые могут потребоваться
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import 'vuetify/dist/vuetify.min.css'
import createStore from "./vuex/states";
Vue.use(Vuetify)

import LeftMenu from '@/vue/LeftMenu'
Vue.component('left-menu', LeftMenu)

const app = new Vue({
  el: '#app',
})