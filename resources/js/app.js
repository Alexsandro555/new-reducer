/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap'

import Vue from 'vue'
window.Vue = Vue

/**
 * Initialize main libraries
 */
//===========Vuex==========================================
import Vuex from 'vuex'
Vue.use(Vuex)
//==========Vuetify========================================
import Vuetify from 'vuetify'
// Импорт CSS-файлов, которые могут потребоваться
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import 'vuetify/dist/vuetify.min.css'
Vue.use(Vuetify)

import dateFns from 'date-fns'
// объявление глобальной библиотеки
Vue.mixin(
  {
    data() { return { dateFns } },
  }
)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */


const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

//window.dark = true

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import createStore from './vuex/states.js'
import { mapActions, mapMutations } from 'vuex'

import Notifications from '@/vue/Notifications.vue'
Vue.component('notifications', Notifications)

const store = new Vuex.Store(createStore())

//==========Router=========================================
/*import VueRouter from 'vue-router'
Vue.use(VueRouter)
import { routes } from './routes'
const router = new VueRouter({
  routes
})*/

import router from './vue/router/vue_router'
//const router = () => import('./vue/router/vue_router.js')

//const initializer = () => import("@initializer/vuex/initializer/state")

const token = localStorage.getItem('user-token')
if (token) {
  axios.defaults.headers.common['Authorization'] = 'Bearer '+token
  // инициализируем начальное состояние
  /*for(var key in store._modulesNamespaceMap) {
    if(store.state[key.substring(0, key.length - 1) ].init) {
      store.dispatch(key.substring(0, key.length - 1)+'/GLOBAL_LOAD')
    }
    if(store.state[key.substring(0, key.length - 1) ].needFields) {
      store.dispatch(key.substring(0, key.length - 1)+'/GLOBAL_INITIALIZATION')
    }
  }*/
}

//import Registration from '@auth/vue/Register'
//import LoginForm from '@auth/vue/LoginForm'
//Vue.component('dialog-registration', Registration)
//Vue.component('dialog-login', LoginForm)

const app = new Vue({
  el: '#app',
  router,
  store,
  created() {
    store.dispatch('initializer/init')
    /*const requreModuleVuex = require.context(
      '../../Modules', true, /state\.js$/
    )*/

    //store.dispatch('initializer/init')
    //this.init()

    /*let states = [];
    const requreModuleVuex = require.context(
      '../../Modules', true, /state\.js$/
    )
    requreModuleVuex.keys().forEach(path => {
      let state = path.replace('/state.js', '')
      states.push({'name': state.substring(state.lastIndexOf('/')+1, state.length), 'path': path})
    })

    states.forEach(state => {
      let name = '../../Modules/'+state.path.substring(2, state.path.length)
      debugger
      let module = () => import(name)
      module().then(element => {
        store.registerModule(state.name,element.default)

      })
    })
    store.dispatch('initializer/init')*/

    /*const initializer = () => import("../../Modules/Callback/Resources/assets/js/vuex/Callback/state.js")
    initializer().then(result => {
      store.registerModule("initializer",result.default)
      store.dispatch('initializer/init')
    })*/




    //store.registerModule("initializer", () => import("@initializer/vuex/initializer/state").then(module => {}))
    //store.dispatch('initializer/init')
  },
  data() {
    return {
      dark: true
    }
  },
  methods: {
    // инициализирует перехват обработки ошибок
    //...mapActions('initializer',{init: 'init'}),
  }
});
