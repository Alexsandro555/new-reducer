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
                <v-select :items="sortedElements" item-text="title" @change="selectOrder" autofocus item-value="id" v-model="sortBy" single-line :append-icon="'$vuetify.icons.dropdown'">
                  <template slot="selection" slot-scope="data">
                    <v-icon>sort</v-icon>
                    <span class="select__text">&nbsp;{{data.item.title}}</span>
                  </template>
                </v-select>
              </v-layout>
            </v-flex>
            <v-flex pa-3 text-xs-left>
              <v-btn-toggle v-model="toggle_exclusive" mandatory>
                <v-btn><v-icon>view_module</v-icon></v-btn>
                <v-btn><v-icon>view_list</v-icon></v-btn>
                <v-btn><v-icon>view_headline</v-icon></v-btn>
              </v-btn-toggle>
            </v-flex>
          </v-layout>
        </v-flex>
      </v-layout>
    </v-flex>
    <div class="filterBody">
      <aside class="filterSidebar">
        <v-expansion-panel v-model="panel" expand>
          <v-expansion-panel-content class="collapseAttribute" v-for="attribute in filteredAttributes"
                                     :key="attribute.id">
            <template slot="header">
              <span class="collapseAttribute__header">{{attribute.title}}</span>
            </template>
            <v-card class="collapseAttribute__content">
              <v-card-title>
                <filter-attributes :items="attribute.attribute_list_value" @attributechanged="updateSelectedAttribute(attribute.id,$event)"/>
              </v-card-title>
            </v-card>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </aside>
      <v-flex xs12>
        <v-layout column wrap>

        </v-layout>
      </v-flex>
    </div>
  </v-layout>
</template>

<script>
  import FilterAttributes from './FilterAttributes'
  import axios from 'axios'

  export default {
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
        toggle_exclusive: null
      }
    },
    mounted() {
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
        for(let key in values) {
          values[key].forEach((value, index, array) => {
            if(params !== '') params+='&'
            params+='param_id'+key+'[]='+value
          })
        }
        params+='&sortBy='+this.sortBy

        axios.get('/filter?'+params)
          .then(response => response.data)
          .then(response => {
            console.log(response)
          })
          .catch(error => {
            console.log(error)
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