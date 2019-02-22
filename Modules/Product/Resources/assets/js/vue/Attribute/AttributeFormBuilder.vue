<template>
  <v-flex xs12>
    <v-text-field
      v-if="attribute.attribute_type_id==2"
      :name="attribute.alias"
      :label="attribute.title"
      :value="getValue"
      @input="updateAttribute($event, attribute.id)">
    </v-text-field>
    <v-text-field
      v-else-if="attribute.attribute_type_id==7"
      :name="attribute.alias"
      :label="attribute.title"
      :value="getValue"
      @input="updateAttribute($event, attribute.id)"
      prefix="₽">
    </v-text-field>
    <v-text-field
      v-else-if="attribute.attribute_type_id==3"
      :name="attribute.alias"
      :label="attribute.title"
      @input="updateAttribute($event, attribute.id)"
      :value="getValue">
    </v-text-field>
    <v-text-field
      v-else-if="attribute.attribute_type_id==4"
      :name="attribute.alias"
      :label="attribute.title"
      @input="updateAttribute($event, attribute.id)"
      :value="getValue">
    </v-text-field>
    <v-checkbox
      v-else-if="attribute.attribute_type_id==1"
      :name="attribute.alias"
      :label="attribute.title"
      @input="updateAttribute($event, attribute.id)"
      :value="getValue">
    </v-checkbox>
    <v-select
      v-else-if="attribute.attribute_type_id==8"
      :name="attribute.alias"
      :items="attribute.attribute_list_value"
      :label="attribute.title"
      :id="attribute.alias"
      no-data-text="Нет данных"
      @input="updateAttribute($event, attribute.id)"
      :value="getValue"
      item-text="title"
      item-value="id"
      single-line>
    </v-select>
    <v-menu
      v-else-if="attribute.attribute_type_id==5"
      v-model="menu"
      transition="scale-transition"
      :nudge-left="40"
      :close-on-content-click="false"
      full-width>
      <v-text-field
        slot="activator"
        :label="attribute.title"
        :value="getValue"
        prepend-icon="event"
        readonly>
      </v-text-field>
      <v-date-picker
        :allowed-dates="v => v>=dateFns.format(Date.now(),'YYYY-MM-DD')"
        v-model="date"
        locale="ru-ru"
        @change="updateDate({date, id: attribute.id})">
      </v-date-picker>
    </v-menu>
  </v-flex>
</template>
<script>
    export default {
      props: {
        attribute: {
          type: Object,
          default: {}
        },
        values: {
          type: Array,
          default: []
        }
      },
      data() {
        return {
          menu: false,
          date: null
        }
      },
      computed: {
        getValue() {
          console.log('work')
          const value = this.values.find(item => item.attribute_id == this.attribute.id)
          return value?value.value:null
        },
      },
      methods: {
        updateDate({date, id}) {
          this.updateAttribute(date, id)
          this.menu = false
        },
        updateAttribute(value, id) {
          let objField = {}
          objField['value'] = value
          objField['id'] = id
          this.$emit('update', objField)
        },
      }
     }
</script>