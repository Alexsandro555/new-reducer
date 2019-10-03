<template>
    <div>
      <input type="checkbox" :value="item.id" v-model="checkedAttributes"/>{{item.title}}
    </div>
</template>
<script>
    export default {
        props: {
          item: {
            type: Object,
            default: () => {}
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