<template>
  <v-container>
    <v-layout align-center justify-center full-height wrap row>
      <v-flex>
        <v-card>
          <v-card-title>
            <h1>Загрузка продукции</h1>
          </v-card-title>
          <v-card-text>
            <v-flex xs12>
              <v-form ref="form" lazy-validation v-model="valid">
                <v-autocomplete
                  v-model="product_category_id"
                  :items="productCategories"
                  :search-input.sync="searchProductCategory"
                  color="white"
                  hide-no-data
                  item-text="title"
                  item-value="id"
                  label="Категория продукта"
                  placeholder="Введите название категории продукта для поиска">
                  <template slot="selection" slot-scope="data">
                    {{ data.item.title }}
                  </template>
                </v-autocomplete>
                <v-autocomplete
                  v-model="type_product_id"
                  :items="getTypeProducts"
                  :search-input.sync="searchTypeProduct"
                  color="white"
                  hide-no-data
                  item-text="title"
                  item-value="id"
                  label="Типы продукта"
                  placeholder="Введите название типа продукта для поиска">
                  <template slot="selection" slot-scope="data">
                    {{ data.item.title }}
                  </template>
                </v-autocomplete>
                <v-autocomplete
                  v-model="line_product_id"
                  :items="getLineProducts"
                  :search-input.sync="searchLineProduct"
                  color="white"
                  hide-no-data
                  item-text="title"
                  item-value="id"
                  label="Линейки продукции"
                  placeholder="Введите название линейки продукции для поиска">
                  <template slot="selection" slot-scope="data">
                    {{ data.item.title }}
                  </template>
                </v-autocomplete>
                <input type="file" id="file" name="file" ref="excel" @change.prevent="onUpload" style="display: none"/>
                <v-flex xs12 text-xs-left>
                  <v-btn
                    :loading="loading"
                    :disabled="loading"
                    color="blue"
                    class="white--text"
                    @click="onShowWindow">
                    Загрузить
                    <v-icon right dark>cloud_upload</v-icon>
                  </v-btn>
                </v-flex>
              </v-form>
            </v-flex>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
  import axios from 'axios'
  import headingMixin from '@product/vue/mixins/HeadingMixin'

  export default {
    props: {},
    data() {
      return {
        loading: false,
        valid: false,
        isSaving: false,
        product_category_id: null,
        type_product_id: null,
        line_product_id: null,
      }
    },
    mixins: [headingMixin],
    methods: {
      onShowWindow() {
        this.$refs.excel.click()
      },
      reset() {
        const input = this.$refs.excel
        input.type = 'text'
        input.type = 'file'
      },
      onUpload() {
        if (this.$refs.form.validate()) {
          this.loading = true
          let formData = new FormData()
          let file = this.$refs.excel
          formData.append("file", file.files[0])
          formData.append("product_category_id", this.product_category_id?this.product_category_id:'')
          formData.append("type_product_id", this.type_product_id?this.type_product_id:'')
          formData.append("line_product_id", this.line_product_id?this.line_product_id:'')
          this.loading = true
          axios.post('/api/products/import', formData , {
            headers: {
              'Content-type': 'multipart/form-data'
            }
          })
          .then(response => response.data)
          .then(response => {
            this.reset()
            this.loading = false
            this.$refs.form.reset()
          }).catch(error => {
            this.reset()
            this.loading = false
            console.error(error)
          })
        }
      }
    }
  }
</script>