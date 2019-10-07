<template>
  <v-layout row wrap>
    <v-flex xs12>
      <v-layout row wrap>
        <v-flex xs7>
          <v-layout class="full-height" column justify-center align-start>
            <span class="headsite-low">Фильтр</span>
          </v-layout>
        </v-flex>
        <v-flex xs5 text-xs-right>
          <v-layout row wrap>
            <v-flex shrink class="select">
              <v-layout align-baseline>
                <v-select :items="sortedElements" item-text="title" @change="selectOrder" autofocus item-value="id"
                          v-model="sortBy" single-line :append-icon="'$vuetify.icons.dropdown'">
                  <template slot="selection" slot-scope="data">
                    <v-icon>sort</v-icon>
                    <span class="select__text">&nbsp;{{data.item.title}}</span>
                  </template>
                </v-select>
              </v-layout>
            </v-flex>
            <v-flex pa-3 text-xs-left>
              <v-btn-toggle v-model="toggle_view" mandatory>
                <v-btn><v-icon>view_module</v-icon></v-btn>
                <v-btn><v-icon>view_list</v-icon></v-btn>
                <v-btn><v-icon>view_headline</v-icon></v-btn>
              </v-btn-toggle>
            </v-flex>
          </v-layout>
        </v-flex>
      </v-layout>
    </v-flex>
    <v-flex xs12 class="filterBody">
      <aside class="filterSidebar">
        <v-expansion-panel v-model="panel" expand>
          <v-expansion-panel-content class="collapseAttribute" v-for="attribute in filteredAttributes"
                                     :key="attribute.id">
            <template slot="header">
              <span class="collapseAttribute__header">{{attribute.title}}</span>
            </template>
            <v-card class="collapseAttribute__content">
              <v-card-title>
                <attributes :items="attribute.attribute_list_value"
                            @attributechanged="updateSelectedAttribute(attribute.id,$event)"/>
              </v-card-title>
            </v-card>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </aside>
      <v-flex xs12>
          <v-layout v-if="isLoading" row justify-center align-center>
            <v-progress-circular indeterminate :size="100" color="primary"></v-progress-circular>
          </v-layout>
          <v-layout v-else row wrap>
            <module-view :products="paginatedProducts" v-if="toggle_view==0"/>
            <list-view :products="paginatedProducts" v-else-if="toggle_view==1"/>
            <table-view :products="paginatedProducts" v-else/>
            <v-flex xs12 text-xs-center>
              <v-pagination v-if="colPages > 1" :total-visible="7" v-model="page" :page="page" :length="colPages"></v-pagination>
            </v-flex>
          </v-layout>
      </v-flex>
    </v-flex>
  </v-layout>
</template>

<script>
  import Attributes from './Attributes'
  import ModuleView from './View/Module'
  import ListView from './View/List'
  import TableView from './View/Table'
  import axios from 'axios'

  export default {
    name: 'FilterProducts',
    props: {
      attributes: {
        type: Array,
        default: () => []
      }
    },
    data() {
      return {
        panel: [],
        selectAttributesValues: {},
        sortedElements: [
          {id: 'sort|asc', title: 'По умолчанию'},
          {id: 'title|asc', title: 'По названию от А до Я'},
          {id: 'title|desc', title: 'По названию от Я до А'},
          {id: 'price|asc', title: 'Цена - по возрастанию'},
          {id: 'price|desc', title: 'Цена - по убыванию'}
        ],
        sortBy: 'sort|asc',
        toggle_view: 0,
        products: [],
        isLoading: false,
        page: 1,
        perPage: 15,
        countedAttributes: []
      }
    },
    mounted() {
    },
    components: {
      Attributes,
      ModuleView,
      ListView,
      TableView
    },
    computed: {
      filteredAttributes() {
        return this.attributes.filter(item => {
          if (item.active && item.filtered && item.attribute_type_id === 8) {
            this.panel.push(true)
            return true
          } else {
            return false
          }
        })
      },
      paginatedProducts() {
        return _.slice(this.products,(this.page-1)*this.perPage,(this.page-1)*this.perPage+this.perPage)
      },
      colPages() {
        return Math.floor(this.products.length/this.perPage)+1
      }
    },
    watch: {
      selectAttributesValues(values) {
        this.sendRequest(values)
      }
    },
    methods: {
      selectOrder() {
        this.sendRequest(this.selectAttributesValues)
      },
      sendRequest(values) {
        let params = ''
        for (let key in values) {
          values[key].forEach((value, index, array) => {
            if (params !== '') params += '&'
            params += 'param_id' + key + '[]=' + value
          })
        }
        params += '&sortBy=' + this.sortBy

        this.isLoading = true
        axios.get('/filter?' + params)
          .then(response => response.data)
          .then(response => {
            this.products = response
            this.attributeHandler(response)
            this.isLoading = false
          })
          .catch(error => {
            this.isLoading = false
            console.log(error)
          })
      },
      attributeHandler(products) {
        products.forEach(product => {
          product.attributes.forEach(attribute => {
            let currentAttribute = this.countedAttributes.find(item => item.id === attribute.id)
            if(currentAttribute) {
              let listValue = currentAttribute.attribute_list_value.find(item => item.id === currentAttribute.pivot.list_value)
              if(listValue) listValue.count+=1
            } else {
              let localAttribute = Object.assign({}, attribute)
              let listValue = localAttribute.attribute_list_value.find(item => item.id === localAttribute.pivot.list_value)
              if(listValue)  {
                listValue.count=1
              }
              this.countedAttributes.push(localAttribute)
            }
          })
        })
      },
      updateSelectedAttribute(attribute_id, event) {
        this.selectAttributesValues = Object.assign({}, this.selectAttributesValues, {[attribute_id]: event})
      }
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

  .select {
    width: 302px;
  }

  .select__text {
    font-size: 1.2em;
  }

  .full-height {
    height: 100%;
  }
</style>