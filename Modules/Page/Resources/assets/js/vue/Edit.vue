<template>
  <v-container>
    <v-layout row wrap>
      <v-progress-circular v-if="loader" indeterminate :size="100" color="primary"></v-progress-circular>
      <v-flex v-if="!loader">
        <v-card>
          <v-card-title><h1>Редактирование страницы</h1></v-card-title>
          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                <v-flex xs12>
                  <v-form ref="form" lazy-validation v-model="valid">
                    <template v-for="(field, num) in fields">
                      <form-builder :field="field" v-if="num !== 'content'" :num="num" :items="form"
                                    @update="updateField"></form-builder>
                    </template>
                    <wysiwyg
                      :element-id="id"
                      name="description"
                      url="image-wysiwyg-upload"
                      url-file="upload-file"
                      type-file-upload="file"
                      type-file="image-wysiwyg"
                      :model="model"
                      v-model="item.content">
                    </wysiwyg>
                  </v-form>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" :disabled="false" flat @click.prevent="onSave()">Сохранить</v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
  import {mapActions, mapMutations, mapGetters, mapState} from 'vuex'
  import {ACTIONS} from '@page/constants'
  import {GLOBAL} from "@/constants";
  import FormBuilder from '@/vue/FormBuilder'
  import Wysiwyg from '@/vue/Wysiwyg.vue'

  export default {
    props: {
      id: {
        type: String,
        required: true
      },
    },
    data: function () {
      return {
        valid: false,
        loader: true,
        isSending: false
      }
    },
    beforeRouteEnter(to, from, next) {
      next(vm => {
        vm.init(to.params.id)
        vm.loader = false
      })
    },
    beforeRouteUpdate(to, from, next) {
      this.init(to.params.id)
      this.loader = false
      next()
    },
    computed: {
      form() {
        return this.getItem(Number(this.id))
      },
      ...mapState('Page', ['item', 'items', 'fields', 'model']),
      ...mapGetters('Page', {getItem: GLOBAL.GET_ITEM}),
    },
    components: {
      FormBuilder,
      Wysiwyg
    },
    methods: {
      init(id) {
        this.resetError();
        if (this.items.length == 0) {
          this.$router.push({name: 'pages'})
        }
      },
      updateField(objField) {
        Object.assign(this.form, objField)
      },
      onSave() {
        if (this.$refs.form.validate()) {
          this.isSending = true
          this.save(this.form).then(response => {
            this.isSending = false
            this.$router.push({name: 'pages'})
          })
        }
      },
      ...mapMutations('initializer', {resetError: 'RESET_ERROR'}),
      ...mapActions('Page', {
        initialization: GLOBAL.INITIALIZATION,
        save: GLOBAL.SAVE_DATA
      })
    }
  }
</script>