<template>
  <v-container>
    <v-layout align-center justify-center full-height wrap row>
      <v-flex xs12>
        <v-progress-circular v-if="isLoading" indeterminate :size="100" color="primary"></v-progress-circular>
        <v-stepper v-else v-model="el">
          <v-stepper-header>
            <v-stepper-step :complete="el > 1" step="1">Загрузка PDF</v-stepper-step>
            <v-divider></v-divider>
            <v-stepper-step :complete="el > 2" step="2">Редактирование атрибутов</v-stepper-step>
            <v-divider></v-divider>
            <v-stepper-step :complete="el > 3" step="2">Загрузка атрибутов</v-stepper-step>
          </v-stepper-header>

          <v-stepper-items>
            <!--Шаг 1-->
            <v-stepper-content step="1">

              <v-card class="mb-12">
                <v-card-actions>
                  <v-layout wrap row justify-end align-right>
                    <!--<v-btn color="primary" :disabled="!parameters.length>0" @click="el = 2; parametersStr = JSON.stringify(parameters)">Продолжить</v-btn>-->
                    <v-btn icon color="primary" :disabled="!parameters.length>0" @click="el = 2; parametersStr = JSON.stringify(parameters)">
                      <v-icon>forward</v-icon>
                    </v-btn>
                  </v-layout>
                </v-card-actions>
                <v-card-text>
                  <v-flex xs12 text-xs-left>
                    <v-alert :type="status.type" :value="status.type">{{status.message}}</v-alert>
                    <v-form ref="form" lazy-validation v-model="valid">
                      <input type="file" ref="pdf" @change="onUpload" style="display: none"/>
                      <v-btn
                        :loading="loading"
                        :disabled="loading"
                        color="blue"
                        class="white--text"
                        @click="onShowWindow">
                        Загрузить PDF
                        <v-icon right dark>cloud_upload</v-icon>
                      </v-btn>
                    </v-form>
                  </v-flex>
                  <v-flex xs12>
                    <div id="html-result"></div>
                  </v-flex>
                </v-card-text>
              </v-card>
            </v-stepper-content>
            <!--Конец Шаг 1-->
            <!--Шаг 2-->
            <v-stepper-content step="2">
              <v-card class="mb-12">
                <v-card-actions>
                  <v-layout wrap row justify-end align-right>
                    <v-btn icon @click="el = 1">
                      <v-icon>backspace</v-icon>
                    </v-btn>
                    <v-btn icon color="primary" :disabled="!parameters.length>0" @click="el = 3">
                      <v-icon>forward</v-icon>
                    </v-btn>
                  </v-layout>
                </v-card-actions>
                <v-card-text>
                  <v-flex xs12>
                    <span hidden>{{getSelected}}</span>
                    <v-flex xs4 text-xs-left>
                      <v-btn color="red" @click="showParameters = !showParameters">Редактировать параметры</v-btn>
                      <div v-if="showParameters">
                        <ul class="record-sel" v-for="(Record, index) in getFormatedParams" :key="`Record-${index}`">
                          <li><b>Строка #{{index+1}}</b></li>
                          <li v-for="(item, indexItem) in Record.items" :key="`item-${index}-${indexItem}`">
                            <v-text-field :value="item" @input="setParameters($event, index, indexItem)"
                                          :key="`item-val-${index}-${indexItem}`"></v-text-field>
                          </li>
                        </ul>
                      </div>
                    </v-flex>
                  </v-flex>
                </v-card-text>
              </v-card>
            </v-stepper-content>
            <!--Конец Шаг 2-->
            <!--Шаг 3-->
            <v-stepper-content step="3">
              <v-card class="mb-12">
                <v-card-actions>
                  <v-layout wrap row justify-end align-right>
                    <v-btn icon @click="el = 2">
                      <v-icon>backspace</v-icon>
                    </v-btn>
                  </v-layout>
                </v-card-actions>
                <v-card-text>
                  <v-flex xs12>
                    <v-form ref="form-attributes" lazy-validation v-model="valid">
                      <v-autocomplete
                        v-model="form.productIds"
                        :items="items"
                        :search-input.sync="searchProducts"
                        color="white"
                        v-if="items"
                        chips
                        hide-no-data
                        item-text="title"
                        item-value="id"
                        label="Продукты"
                        placeholder="Введите название продукта для поиска"
                        multiple>
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
                      </v-autocomplete>
                      <v-autocomplete
                        v-model="form.attributeIds"
                        :items="attributes"
                        :search-input.sync="searchAttributes"
                        v-if="attributes"
                        color="white"
                        chips
                        hide-no-data
                        item-text="title"
                        item-value="id"
                        label="Атрибуты"
                        placeholder="Введите название атрибута для поиска"
                        multiple>
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
                      </v-autocomplete>
                      <!--<v-checkbox
                        label="Атрибуты по-горизонтали"
                        v-model="form.direction">
                      </v-checkbox>-->
                      <v-flex text-xs-left>
                        <v-btn text-xs-left large :class="{primary: valid, 'red lighten-3': !valid}"
                               :disabled="isSaving" @click.prevent="onSave">
                          Сохранить
                        </v-btn>
                      </v-flex>
                    </v-form>
                    <span hidden>{{getSelected}}</span>
                    <!--<v-flex xs4 text-xs-left>
                      Выбранные значения: <br>
                      <ul class="record-sel" v-for="(Record, index) in getFormatedParams" :key="`Record-${index}`">
                        <li><b>Строка #{{index+1}}</b></li>
                        <li v-for="(item, indexItem) in Record.items" :key="`item-${index}-${indexItem}`">
                          <v-text-field :value="item" @input="setParameters($event, index, indexItem)" :key="`item-val-${index}-${indexItem}`"></v-text-field>
                        </li>
                      </ul>
                    </v-flex>-->
                  </v-flex>
                </v-card-text>
              </v-card>
            </v-stepper-content>
            <!--Конец Шаг 3-->
          </v-stepper-items>
        </v-stepper>
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
  import {mapActions, mapState} from 'vuex'
  import {GLOBAL} from '@/constants'
  import {ACTIONS} from '@product/constants'
  import PDFJS from 'pdfjs-dist'
  import {pdfTableExtractor} from './PdfTableExtractor/pdf_table_extractor'
  import TableSelection from './PdfTableExtractor/TableSelection'

  export default {
    props: {},
    data() {
      return {
        el: 0,
        loading: false,
        valid: false,
        isLoading: false,
        isSaving: false,
        searchProducts: null,
        searchAttributes: null,
        defaultForm: {
          productIds: [],
          attributeIds: [],
          direction: false
        },
        form: {
          productIds: [],
          attributeIds: [],
          direction: false
        },
        products: [],
        status: {
          message: '',
          type: null
        },
        ts: new TableSelection(),
        parameters: [],
        parametersStr: null,
        showParameters: false
      }
    },
    mounted() {
      this.isLoading = true
      let loadProducts = this.load()
      let loadAttributes = this.loadAttributes()
      Promise.all([loadProducts, loadAttributes]).then(result => {
        this.isLoading = false
      })
    },
    computed: {
      ...mapState('products', ['items']),
      ...mapState('attributes', {attributes: state => state.items}),
      getSelected() {
        this.parameters = []
        this.parameters = [...this.ts.getArraySelectionText()]
        return this.ts.getArraySelectionText()
      },
      getFormatedParams() {
        return this.parameters.map(param => {
          return Array.isArray(param) ? {items: param} : param
        })
      }
    },
    methods: {
      removes(item) {
        const index = this.items.indexOf(item.name)
        if (index >= 0) this.items.splice(index, 1)
      },
      reset() {
        const input = this.$refs.pdf
        input.type = 'text'
        input.type = 'file'
      },
      onSave() {
        if (this.$refs['form-attributes'].validate()) {
          this.status.message = ''
          this.status.type = null
          this.isSaving = true
          this.save(Object.assign({}, this.form, {values: this.parametersStr}))
              .then(response => {
                this.isSaving = false
                this.parameters = []
                this.parametersStr = null
                this.el = 1
              }).catch(error => {
                this.isSaving = false
              })
        }
      },
      onShowWindow() {
        this.$refs.pdf.click()
      },
      onUpload() {
        if (this.$refs.form.validate()) {
          let obj = this.$refs.pdf
          if (obj.files.length !== 0 && obj.files.item(0).type.indexOf('pdf') !== -1) {
            this.parameters = []
            $('#html-result').html('<br>');
            this.loading = true
            this.status.message = 'Загрузка файла'
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
          } else {
            this.status.message = 'Допустимый формат файла pdf'
            this.status.type = 'error'
          }
          this.reset()
        }
      },
      setParameters(event, index, subIndex) {
        this.parameters[index][subIndex] = event
      },
      parseContent(content) {
        PDFJS.GlobalWorkerOptions.workerSrc = './js/pdf.worker.js'
        PDFJS.cMapUrl = './../node_modules/pdfjs-dist/cmaps/'
        PDFJS.cMapPacked = true

        PDFJS.getDocument(content).then(pdfTableExtractor).then(result => {
          this.status.type = null
          this.status.message = ''
          var all_tables = [];
          var page_tables;
          while (page_tables = result.pageTables.shift()) {
            var timestamp = new Date().getUTCMilliseconds();
            var table_dom = $('<table id="' + timestamp + '" style="border-collapse: collapse; table-layout: fixed; margin-bottom: 50px; border-spacing: 2px; border-color: grey;" ' +
              'class="table-selection"><tbody></tbody></table>').attr('border', 1);
            var tables = page_tables.tables;
            var merge_alias = page_tables.merge_alias;
            var merges = page_tables.merges;

            for (var r = 0; r < tables.length; r++) {
              var tr_dom = $('<tr></tr>');
              for (var c = 0; c < tables[r].length; c++) {
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

          }
          this.loading = false;
          //this.ts = new TableSelection();
        }).catch(error => {
          this.loading = false;
          console.error(error)
        })
      },
      ...mapActions('products', {load: GLOBAL.LOAD}),
      ...mapActions('attributes', {loadAttributes: GLOBAL.LOAD}),
      ...mapActions('attribute_values', {save: ACTIONS.SAVE_MULTIPLE})
    }
  }
</script>

<style>
  .content-wrapper {
    overflow: scroll;
    margin-top: 100px;
  }

  .table-selection *::selection {
    background: transparent;
    color: inherit;
  }

  .table-selection *::-moz-selection {
    background: transparent;
    color: inherit;
  }

  .table-selection td.selected {
    background: rgba(0, 123, 255, .25);
  }

  .record-sel {
    list-style-type: none;
  }
</style>