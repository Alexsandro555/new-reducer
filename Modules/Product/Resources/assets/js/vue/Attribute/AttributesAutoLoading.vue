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
              <!--<v-autocomplete
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
                ></v-autocomplete>-->
            </v-flex>
            <v-flex xs12>
              <v-form ref="form" lazy-validation v-model="valid">
                <input type="file" ref="pdf" @change="onUpload" style="display: none"/>
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
              <v-alert v-if="status.type">{{status.message}}</v-alert>
            </v-flex>
            <v-flex id="html-result">
            </v-flex>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
  import PDFJS from 'pdfjs-dist'
  import {pdfTableExtractor} from './PdfTableExtractor/pdf_table_extractor'
  //require('table-selection/dist/js/table-selection')
  require('./PdfTableExtractor/cellSelection.min.js')

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
        },
        status: {
          message: '',
          type: null
        }
      }
    },
    methods: {
      onShowWindow() {
        this.$refs.pdf.click()
      },
      onUpload() {
        if (this.$refs.form.validate()) {
          this.loading = true
          this.status.message = 'Перемещение файла'
          this.status.type = 'info'
          let file = this.$refs.pdf.files[0]
          {
            let reader = new FileReader()
            let name = file.name
            reader.onload = (e) => {
              let data = e.target.result
              this.status.message = 'Парсинг PDF'
              this.parseContent(data)
            }
            reader.readAsArrayBuffer(file)
          }
        }
      },
      parseContent(content) {
        PDFJS.GlobalWorkerOptions.workerSrc = './js/pdf.worker.js'
        PDFJS.cMapUrl = './../node_modules/pdfjs-dist/cmaps/'
        PDFJS.cMapPacked = true

        PDFJS.getDocument(content).then(pdfTableExtractor).then(result => {
          var all_tables = [];
          var page_tables;
          while (page_tables = result.pageTables.shift()) {
            var timestamp = new Date().getUTCMilliseconds();
            var table_dom = $('<table id="'+timestamp+'" style="border-collapse: collapse; table-layout: fixed; margin-bottom: 50px; border-spacing: 2px; border-color: grey;"></table>').attr('border', 1);
            var tables = page_tables.tables;
            var merge_alias = page_tables.merge_alias;
            var merges = page_tables.merges;

            for (var r = 0; r < tables.length; r ++) {
              var tr_dom = $('<tr></tr>');
              for (var c = 0; c < tables[r].length; c ++) {
                var r_c = [r, c].join('-');
                if (merge_alias[r_c]) {
                  continue;
                }
                var td_dom = $('<td></td>');
                if (merges[r_c]) {
                  if (merges[r_c].width > 1) {
                    td_dom.attr('colspan', merges[r_c].width);
                  }
                  if (merges[r_c].height > 1) {
                    td_dom.attr('rowspan', merges[r_c].height);
                  }
                }
                td_dom.text(tables[r][c]);
                tr_dom.append(td_dom);
              }
              table_dom.append(tr_dom);
            }
            $('#html-result').append(table_dom);
            console.log(timestamp)
            $('#'+timestamp).cellSelection('selectAll');
          }
          this.loading = false;
        })
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