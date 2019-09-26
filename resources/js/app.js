/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap'

//==========Vue============================================
import Vue from 'vue'
window.Vue = Vue
//==========End Vue========================================

//===========Vuex==========================================
import Vuex from 'vuex'
import createStore from './vuex/states.js'
import { mapActions, mapMutations, mapState } from 'vuex'
Vue.use(Vuex)
const store = new Vuex.Store(createStore())
//===========End Vuex======================================

//==========Vee-validate===================================
//import ru from 'vee-validate/dist/locale/ru';
//import VeeValidate, { Validator } from 'vee-validate'
//Vue.use(VeeValidate)
//Validator.localize('ru', ru)
//===========End Vee-validate==============================


//==========Vuetify========================================
import Vuetify from 'vuetify'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import 'vuetify/dist/vuetify.min.css'
Vue.use(Vuetify)
//===========End Vuetify===================================

//===========Date==========================================
import dateFns from 'date-fns'
// объявление глобальной библиотеки
Vue.mixin(
  {
    data() { return { dateFns } },
  }
)
//============End date======================================


//============Register global components====================
//Automatic register components - это нужно сделать по всем модулям - сильно упростит жизнь - я дуаю их следует размещать в специальной папке global
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

import Notifications from '@/vue/Notifications.vue'
Vue.component('notifications', Notifications)
//=============End register global components===============

//=============Router=======================================
import router from './vue/router/vue_router'
//=============End router===================================


//=============Auth token===================================
const token = localStorage.getItem('user-token')
if (token) {
  axios.defaults.headers.common['Authorization'] = 'Bearer '+token
}
//=============End auth token===============================

const app = new Vue({
  el: '#app',
  router,
  store,
  created() {
    store.dispatch('initializer/init')
  },
  computed: {
    ...mapState('initializer', ['darkColor']),
  },
  data() {
    return {
      dark: true
    }
  },
  methods: {
    chengeColor() {
      this.dark = !this.dark
    }
  }
});
