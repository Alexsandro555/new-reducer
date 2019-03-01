<template>
  <v-container>
    <v-layout wrap row>
      <v-flex xs12 class="text-xs-center">
        <v-card>
          <v-card-title>
            <h1>Страницы</h1>
            <v-spacer></v-spacer>
            <v-text-field v-model="search" append-icon="search" label="Поиск" single-line hide-details></v-text-field>
          </v-card-title>
          <v-card-text>
            <v-data-table :headers="headers"
                          :items="items"
                          :search="search"
                          :loading="loading"
                          :rows-per-page-items="[10, 20, 50, { 'text': '$vuetify.dataIterator.rowsPerPageAll', 'value': -1 } ]"
                          rows-per-page-text="Строк на странице:"
                          class="elevation-1">
              <template slot="items" slot-scope="props">
                <td>{{ props.item.id }}</td>
                <td class="text-xs-left">{{ props.item.title }}</td>
                <td class="justify-center layout px-0">
                  <v-btn icon class="mx-0" @click="$router.push('/page/edit/'+props.item.id)">
                    <v-icon color="teal">edit</v-icon>
                  </v-btn>
                  <v-btn :disabled="props.item.url_key === 'po-umolchaniyu'" icon class="mx-0" :key="props.item.id"
                         @click="deleteItem(props.item)">
                    <v-icon color="pink">delete</v-icon>
                  </v-btn>
                </td>
              </template>
              <template v-if="loading" slot="no-data">
                <br>
                <v-progress-circular indeterminate :size="100" color="primary"></v-progress-circular>
                <br>
                <br>
              </template>
              <template v-if="!loading" slot="no-data">
                <v-alert v-if="!loading" :value="true" color="error" icon="warning">
                  Извините, нет данных для отображения :(
                </v-alert>
              </template>
              <v-alert slot="no-results" :value="true" color="error" icon="warning">
                По ключевой фразе "{{ search }}" ничего не найдено.
              </v-alert>
            </v-data-table>
          </v-card-text>
          <v-card-actions>
            <v-btn @click="addItem" color="primary" dark class="text-left mb-2">
              <v-icon>add</v-icon>
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
  import {ACTIONS} from "@page/constants";
  import {GLOBAL} from "@/constants";
  import {mapActions, mapState} from 'vuex'

  export default {
    data: function () {
      return {
        headers: [
          {
            text: '#',
            align: 'left',
            sortable: false,
            value: 'id'
          },
          {
            text: 'Заголовок',
            value: 'title',
            sortable: false
          },
          {
            text: 'Действия',
            value: 'title',
            sortable: false
          }
        ],
        search: ''
      }
    },
    beforeRouteEnter(to, from, next) {
      next(vm => {
        vm.initialization()
        vm.loadAll().then(response => {
          vm.$store.commit('SET_VARIABLE',{module: 'news', variable: 'loading', value: false}, {root: true})
        })
      })
    },
    computed: {
      ...mapState('pages', ['items', 'loading']),
    },
    methods: {
      addItem() {
        this.add({'title': 'По-умолчанию', 'url_key': 'po-umolchaniyu'}).then(response => {
          this.$router.push({name: 'edit-page', params: {id: response.id.toString()}})
        })
      },
      deleteItem(item) {
        if (confirm('Вы уверены что хотите удалить запись?')) {
          this.delete(item.id)
        }
      },
      ...mapActions('pages', {load: GLOBAL.LOAD, add: GLOBAL.ADD, delete: GLOBAL.DELETE, initialization: GLOBAL.INITIALIZATION, loadAll: GLOBAL.LOAD_ALL})
    }
  }
</script>