<template>
  <div>
    <v-layout row wrap v-if="products.length>0">
      <div class="product-wrapper" v-for="product in products">
        <div class="product">
          <div class="product-image-wrapper">
            <div class="product-image" @click="goPage('/catalog/detail/'+product.url_key)">
              <template v-if="getImages(product).length > 0">
                <img :src="'/storage/'+getImages(product)[0].config.files.medium.filename"/>
              </template>
              <template v-else>
                <img src="/images/no-image-medium.png"/>
              </template>
            </div>
          </div>
          <div class="product__title">
            <a :href="'/catalog/detail/'+product.url_key">
              {{product.title.substr(0, 42)}}
            </a>
          </div>
          <v-layout row wrap>
            <v-flex xs8 text-xs-center>
              <br>
              <span class="product-price-wrapper">
                    <span class="product-price">{{product.price}}</span> руб.</span>
            </v-flex>
            <v-flex xs4>
              <img @click="addCart(product.id)" src="/images/btn-sale.png"/>
            </v-flex>
          </v-layout>
        </div>
      </div>
    </v-layout>
    <div v-else>
      <h2>Продукция с заданными параметрами не была найдена</h2>
    </div>
  </div>
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
      return {}
    },
    mounted() {
    },
    methods: {
      getImages(product) {
        let files = []
        if(product.product_category && product.product_category.files.length > 0) {
          files = _.concat(files,product.product_category.files)
        }
        if(product.type_product && product.type_product.files.length > 0) {
          files = _.concat(files, product.type_product.files)
        }
        if(product.line_product && product.line_product.files.length > 0) {
          files = _.concat(files, product.line_product.files)
        }
        if(product.files.length > 0) {
          files = _.concat(files, product.files)
        }
        files = files.filter(item => item.image_view_id == product.image_view_id || _.isNull(item.image_view_id))
        return _.shuffle(files)
      },
      goPage(url) {
        window.location.href=url
      }
    }
  }
</script>