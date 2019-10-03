<template>
  <v-layout row wrap>
    <div class="filterBody">
      <aside class="filterSidebar">
        <v-expansion-panel v-model="panel" expand>
          <v-expansion-panel-content class="collapseAttribute" v-for="attribute in filteredAttributes" :key="attribute.id">
            <template slot="header">
              <span class="collapseAttribute__header">{{attribute.title}}</span>
            </template>
            <v-card class="collapseAttribute__content">
              <v-card-title>
                  <filter-attributes :items="filterItems(attribute.attribute_list_value, attribute.id)" :title="itemText(item)" @attributechanged="updateSelectedAttribute(attribute.id,$event)"/>
              </v-card-title>
            </v-card>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </aside>
      <div class="filterContent">
        <v-flex xs12 v-if="attributes.length > 0">
          <v-layout row wrap>
            <v-flex pa-3 md3 xs12 v-for="attribute in filteredAttributes" :key="attribute.id">
              <v-select
                :label="attribute.title"
                :items="filterItems(attribute.attribute_list_value)"
                :value="selectAttributesValues[attribute.id]"
                @change="selectItem($event,attribute.id)"
                multiple
                :menu-props="{maxHeight: '400'}"
                :item-text="itemText"
                item-value="id"
                no-data-text="Нет данных"
                attach
                chips>
                <template slot="selection" slot-scope="data">
                  <v-chip
                    close
                    @input="data.parent.selectItem(data.item)"
                    :selected="data.selected"
                    class="chip--select-multi"
                    :key="JSON.stringify(data.item)">
                    {{ data.item.title }}
                  </v-chip>
                </template>
              </v-select>
            </v-flex>
          </v-layout>
        </v-flex>
        <v-flex xs12>
          <v-layout column wrap>
            <v-layout row wrap v-if="filteredProducts.length > 0">
              <div class="product-wrapper" v-for="product in getPagesElement">
                <div class="product">
                  <div class="product-image-wrapper">
                    <div class="product-image" @click="goPage('/catalog/detail/'+product.url_key)">
                      <template v-if="getImages(product).length > 0">
                        <img :src="'/storage/'+getImages(product)[0].config.files.medium.filename"/>
                      </template>
                      <template v-else>
                        <img src="/images/no-image-medium.png"/>
                      </template>
                    </div>
                  </div>
                  <div class="product__title">
                    <a :href="'/catalog/detail/'+product.url_key">
                      {{product.title.substr(0, 42)}}
                    </a>
                  </div>
                  <v-layout row wrap>
                    <v-flex xs8 text-xs-center>
                      <br>
                      <span class="product-price-wrapper">
                    <span class="product-price">{{product.price}}</span> руб.</span>
                    </v-flex>
                    <v-flex xs4>
                      <img @click="addCart(product.id)" src="/images/btn-sale.png"/>
                    </v-flex>
                  </v-layout>
                </div>
              </div>
            </v-layout>
            <div v-else>
              <h2>Продукция с заданными параметрами не была найдена</h2>
            </div>
            <div class="text-xs-center">
              <v-pagination v-if="colPages > 1" :total-visible="7" v-model="page" :page="page" :length="colPages"></v-pagination>
            </div>
          </v-layout>
        </v-flex>
      </div>
    </div>

  </v-layout>
</template>

<script>
  import FilterAttributes from './FilterAttributes'
  import { mapActions, mapMutations } from 'vuex'
  import {ACTIONS, MUTATIONS} from '@cart/constants'

  export default {
    props: {
      products: {
        type: Array,
        default: []
      },
      attributes: {
        type: Array,
        default: () => []
      }
    },
    data() {
      return {
        filterAttributes: [],
        page: 1,
        perPage: 15,
        attrListCount: {},
        checkedAttributes: {},
        selectValuesAttributes: {},
        selectAttributesValues: {},
        panel: [],
        currentAttributeId: null
      }
    },
    components: {
      FilterAttributes
    },
    computed: {
      filteredAttributes() {
        return this.attributes.filter(item => {
          if(item.active && item.filtered && item.attribute_type_id === 8) {
            this.panel.push(true)
            return true
          } else {
            return false
          }
        })
      },
      filteredProducts() {
        this.handleAttributes(this.getFilteredProducts(this.selectAttributesValues))
        return this.getFilteredProducts(this.selectAttributesValues)
      },
      getPagesElement() {
        return _.slice(this.filteredProducts,(this.page-1)*this.perPage,(this.page-1)*this.perPage+this.perPage)
      },
      colPages() {
        return Math.floor(this.filteredProducts.length/this.perPage)+1
      },
      filtProd() {
        this.handleAttributes(this.filteredProducts)
        return this.filteredProducts
      },
    },
    mounted() {
      this.attributes.forEach(attribute => {
        Vue.set(this.selectAttributesValues, attribute.id, [])
        Vue.set(this.selectValuesAttributes, attribute.id, [])
      })
    },
    methods: {
      getImages(product) {
        let files = []
        if(product.product_category && product.product_category.files.length > 0) {
          files = _.concat(files,product.product_category.files)
        }
        if(product.type_product && product.type_product.files.length > 0) {
          files = _.concat(files, product.type_product.files)
        }
        if(product.line_product && product.line_product.files.length > 0) {
          files = _.concat(files, product.line_product.files)
        }
        if(product.files.length > 0) {
          files = _.concat(files, product.files)
        }
        files = files.filter(item => item.image_view_id == product.image_view_id || _.isNull(item.image_view_id))
        return _.shuffle(files)
      },
      goPage(url) {
        window.location.href=url
      },
      addCart(id) {
        const count = 1
        this.addCartItem({id, count})
        this.showCartModal()
      },
      updateSelectedAttribute(attribute_id, event) {
        this.currentAttributeId = attribute_id
        Vue.set(this.selectAttributesValues, attribute_id, event)
      },
      selectItem(event,id,index) {
        console.log(event)
        this.page = 1
        let obj = {}
        let arr = this.selectAttributesValues[id]
        arr.push(index)
        obj = {id: arr}
        this.selectAttributesValues = Object.assign({}, this.selectAttributesValues, obj)
      },
      reset() {
        this.page = 1
        this.filteredProducts = this.products
        this.attributes.forEach(attribute => {
          attribute.value = null
        })
      },
      filteredValueAttributes(values) {
        return values.filter(value => {
          let result = this.filteredProducts.find(function(element) {
            let regExp = RegExp(` ${value.title.replace(/,/i, '.')}`, "gi")
            return !_.isNull(element.title.match(regExp))
          })
          return !_.isUndefined(result)
        })
      },
      handleAttributes(products) {
        Vue.set(this.attrListCount, this.currentAttributeId, this.attrListCount[this.currentAttributeId])
        products.forEach(item => {
          item.attributes.forEach(attribute => {
            if(attribute.id !== this.currentAttributeId) this.handleAttribute(attribute)
          })
        })
      },
      handleAttribute(attribute) {
        if(this.attrListCount[attribute.pivot.list_value]) {
          this.attrListCount[attribute.pivot.list_value]+=1
        }
        else {
          this.attrListCount[attribute.pivot.list_value]=1
        }
        return
      },
      itemText(item) {
        return item.title + ' ('+this.attrListCount[item.id]+')'
      },
      filterItems(items, attribute_id) {
       return items.filter(item => !_.isUndefined(this.attrListCount[item.id]))
      },
      getFilteredProducts(attributes) {
        let result = []
        let products = this.products
        for(let index in attributes) {
          products.filter(product => !_.isUndefined(product.attributes.find(item => item.id == index && attributes[index].includes(item.pivot.list_value)))).forEach(product => {
            if(_.isUndefined(result.find(item => item.id == product.id))) {
              result.push(product)
            }
          })
          products = result.length>0?result:products
          result = []
        }
        return products
      },
      ...mapActions('cart',{addCartItem: ACTIONS.ADD_CART}),
      ...mapMutations('cart', {showCartModal: MUTATIONS.SHOW_MODAL})
    }
  }
</script>

<style scoped>
  .filterBody {
    display: flex;
    flex-direction: row;
    border-top: 1px solid #d3d4d6;
  }
  .filterSidebar {
    width: 285px;
    flex: 0 0 285px;
    margin-right: 20px;
    display: block;
  }
  .filterContent {
    flex: 1;
  }
  .collapseAttribute__header {
    font-weight: bold;
  }
  .collapseAttribute__content {
    padding: 0 20px 20px;
  }
</style>