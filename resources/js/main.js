import './bootstrap'

//===========Vue===========================================
import Vue from 'vue'
window.Vue = Vue
//===========End Vue=======================================

//===========Vuex==========================================
import Vuex from 'vuex'
import createStore from "./vuex/states"
import { mapActions, mapMutations } from 'vuex'
import mutations from "./vuex/mutations";
import getters from "./vuex/getters";
import {ACTIONS, MUTATIONS} from '@cart/constants'
Vue.use(Vuex)
//===========End Vuex======================================

//==========Vuetify========================================
import Vuetify from 'vuetify'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import 'vuetify/dist/vuetify.min.css'
Vue.use(Vuetify)
//==========End vuetify====================================


//==========Register global components=====================
import LeftMenu from '@/vue/LeftMenu'
Vue.component('left-menu', LeftMenu)

import DetailImage from '@file/vue/DetailImage'
Vue.component('detail-image', DetailImage)

import CartWidget from '@cart/vue/Widget'
Vue.component('cart-widget',CartWidget)

import CartModal from '@cart/vue/CartModal'
import cart from '@cart/vuex/store'
Vue.component('cart-modal', CartModal)

import CartPage from '@cart/vue/Cart'
Vue.component('cart-page', CartPage)

import Callback from '@callback/vue/callbacks/Callback.vue'
import callback from '@callback/vuex/callbacks/state'
Vue.component('callback', Callback)

import NavigationMenu from '@initializer/vue/NavigationMenu'
Vue.component('navigation-menu', NavigationMenu)

import FilterProducts from '@product/vue/Product/FilterProducts'
Vue.component('filter-products', FilterProducts)

import FilterProducts3 from '@product/vue/Product/FilterProducts3/'
Vue.component('filter-products3', FilterProducts3)

import OrderForm from '@order/vue/OrderForm'
Vue.component('order-form', OrderForm)
//==========End register global components==================

//==========Initializer=====================================
import initializer from '@initializer/vuex/initializer/state'
//==========End initializer=================================

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