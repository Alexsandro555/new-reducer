<template>
  <v-container>
    <v-layout align-center justify-center full-height wrap row>
      <v-flex>
        <v-card>
          <v-card-title>
            <h1>Загрузка атрибутов</h1>
          </v-card-title>
          <v-card-text>
            <v-flex xs12>
              <v-autocomplete
                v-model="form.productIds"
                :items="items"
                :loading="isLoading"
                :search-input.sync="search"
                color="white"
                hide-no-data
                hide-selected
                item-text="title"
                item-value="id"
                label="Продукты"
                placeholder="Введите продукт для поиска"
                prepend-icon="mdi-database-search"
                return-object
                ></v-autocomplete>
            </v-flex>
            <hr>
            <v-flex xs12>
              <v-form ref="form" lazy-validation v-model="valid">
                <input type="file" ref="file" @change="onUpload" style="display: none"/>
                <v-btn
                  :loading="loading"
                  :disabled="loading"
                  color="blue"
                  class="white--text"
                  @click="onShowWindow">
                  Загрузить
                  <v-icon right dark>cloud_upload</v-icon>
                </v-btn>
              </v-form>
            </v-flex>
            <v-flex xs12 class="content-wrapper">
              <plaintext ref="content"></plaintext>
            </v-flex>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
  import axios from 'axios'

  export default {
    props: {},
    data() {
      return {
        loading: false,
        valid: false,
        isLoading: false,
        search: null,
        form: {
          productIds: []
        }
      }
    },
    methods: {
      onShowWindow() {
        this.$refs.file.click()
      },
      onUpload() {
        if (this.$refs.form.validate()) {
          let formData = new FormData()
          let file = this.$refs.file
          formData.append("file", file.files[0])
          this.loading = true
          axios.post('/api/attributes/load-pdf', formData, {
            headers: {
              'Content-type': 'multipart/form-data'
            }
          })
            .then(response => response.data)
            .then(response => {
              this.loading = false
              this.$refs.content.innerHTML = response
            }).catch(error => {
            console.error(error)
          })
        }
      }
    }
  }
</script>

<style scoped>
  .content-wrapper {
    overflow: scroll;
    height: 400px;
    margin-top: 100px;
    /*width: 1200px;
    display: block;
    position: fixed;*/
  }
</style>