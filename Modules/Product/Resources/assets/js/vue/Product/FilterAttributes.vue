<template>
    <div>
      <div v-for="item in items">
        <input type="checkbox" :value="item.id" v-model="checkedAttributes"/>{{item.title}}
      </div>
    </div>
</template>
<script>
    export default {
        props: {
          items: {
            type: Array,
            default: () => []
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