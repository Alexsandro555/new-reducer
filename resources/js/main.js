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

import DetailImage from '@file/vue/DetailImage'
Vue.component('detail-image', DetailImage)

import { mapActions, mapMutations } from 'vuex'
import {ACTIONS, MUTATIONS} from '@cart/constants'

import CartWidget from '@cart/vue/Widget'
import mutations from "./vuex/mutations";
import getters from "./vuex/getters";
Vue.component('cart-widget',CartWidget)

import CartModal from '@cart/vue/CartModal'
Vue.component('cart-modal', CartModal)

import CartPage from '@cart/vue/Cart'
Vue.component('cart-page', CartPage)

// Обратный звонок
import Callback from '@callback/vue/callbacks/Callback.vue'
import callback from '@callback/vuex/callbacks/state'
Vue.component('callback', Callback)

// Initializer
import initializer from '@initializer/vuex/initializer/state'

import cart from '@cart/vuex/store'
const store = new Vuex.Store({
  modules: {
    cart,
    callback,
    initializer,
  },
  mutations,
  getters
  }
)

import NavigationMenu from '@initializer/vue/NavigationMenu'
Vue.component('navigation-menu', NavigationMenu)
//import FilterProducts from '@/components/FilterProducts'
import FilterProducts from '@product/vue/Product/FilterProducts'
Vue.component('filter-products', FilterProducts)

import FilterProducts3 from '@product/vue/Product/FilterProducts3/'
Vue.component('filter-products3', FilterProducts3)

// Order
import OrderForm from '@order/vue/OrderForm'
Vue.component('order-form', OrderForm)

const app = new Vue({
  el: '#app',
  data: {
    searchText: '',
  },
  store,
  methods: {
    goToPage(url) {
      window.location.href=url
    },
    addCart(id) {
      const count = 1
      this.addCartItem({id, count})
      this.showCartModal()
    },
    search(event) {
      const text = event.target.value.replace('/','_')
      window.location.href='/find/'+ text
      this.searchText = ''
    },
    showCallback() {
      this.$store.commit('SET_VARIABLE', {module: 'callback', variable: 'isVisible', value: true})
    },
    ...mapActions('cart',{addCartItem: ACTIONS.ADD_CART}),
    ...mapMutations('cart', {showCartModal: MUTATIONS.SHOW_MODAL})
  }
})