<template>
  <div>
    <div v-for="item in items">
      <input type="checkbox" :value="item.id" v-model="checkedAttributes"/>&nbsp;{{item.title}}&nbsp;{{item.count?'('+item.count+')':''}}
    </div>
  </div>
</template>
<script>
  export default {
    name: 'FilterableAttributes',
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