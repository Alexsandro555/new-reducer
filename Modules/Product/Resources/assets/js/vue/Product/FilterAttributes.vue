<template>
    <div>
      <div v-for="item in items">
        <input type="checkbox" :value="item.id" v-model="checkedAttributes"/>{{itemText(item)}}
      </div>
    </div>
</template>
<script>
    export default {
        props: {
          items: {
            type: Array,
            default: () => []
          },
          attrListCount: {
            type: Object,
            required: true
          },
          attributeId: {
            type: Number,
            required: true
          }
        },
        data() {
            return {
              checkedAttributes: []
            }
        },
        watch: {
          checkedAttributes() {
            this.$emit('attributechanged', this.checkedAttributes)
          }
        },
      methods: {
        itemText(item) {
          return item.title + ' (' + this.attrListCount[this.attributeId][item.id] + ')'
        },
      }
     }
</script>