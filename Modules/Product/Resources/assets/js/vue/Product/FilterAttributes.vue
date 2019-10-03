<template>
    <div>
      <div v-for="item in items">
        <input type="checkbox" :value="item.id" v-model="checkedAttributes"/>{{title}}
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
          title: {
            type: String,
            default: ''
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
        }
     }
</script>