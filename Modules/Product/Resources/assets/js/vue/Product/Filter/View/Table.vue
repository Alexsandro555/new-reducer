<template>
  <v-flex xs12>
    <v-data-table hide-actions :headers="headers" :items="products" class="elevation-1">
      <template slot="items" slot-scope="props">
        <td>{{ props.item.title }}</td>
        <td class="text-xs-left">{{ props.item.price }}</td>
        <td class="justify-center layout px-0">
          <v-btn @click="goToPage(props.item)" icon class="mx-0">
            <v-icon>find_in_page</v-icon>
          </v-btn>
        </td>
      </template>
    </v-data-table>
  </v-flex>
</template>
<script>
  export default {
    props: {
      products: {
        type: Array,
        default: () => []
      }
    },
    data() {
      return {
        headers: [
          {
            text: 'Наименование',
            value: 'title',
            sortable: false
          },
          {
            text: 'Цена',
            value: 'price',
            sortable: false
          },
          {
            text: '',
            value: 'title',
            align: 'center',
            sortable: false
          }
        ]
      }
    },
    mounted() {
    },
    methods: {}
  }
</script>