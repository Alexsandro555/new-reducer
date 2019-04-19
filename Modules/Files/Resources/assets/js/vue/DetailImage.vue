<template>
  <div v-if="items.length>0" class="detail__image--wrapper">
    <div v-if="stock" class="detail__image-label">
      Акция!
    </div>
    <div class="detail__image">
      <div class="image-wrapper">
        <img v-if="curImage" :src="curImage"/>
        <img v-else src="/images/no-image.png"/>
      </div>
      <div class="thumbnails-slider">
        <carousel :items="3" :nav="false" :dots="false" :margin="5">
          <div  v-for="item of items" :key="item.id">
            <img @click="selectSlide(item.id)"  :src="'/storage/'+item.file"/>
          </div>
          <template slot="prev"><img class="nav-arrow-left" src="/images/slider-left-arrow.png"/></template>
          <template slot="next">
            <img  align="center" class="nav-arrow-right" src="/images/slider-right-arrow.png"/></template>
        </carousel>
      </div>
    </div>
  </div>
</template>
<script>
  import axios from 'axios'
  import carousel from 'vue-owl-carousel'

  export default {
    props: {
      url: String,
      stock: {
        Type: Boolean,
        default: false
      }
    },
    data: function () {
      return {
        elements: [],
        items: [],
        curImage: '',
      }
    },
    mounted() {
      axios.get(this.url).then(response => {
        this.elements = response.data
        response.data.forEach(element => {
          this.items.push({'id': element.id, 'file': element.config.files.small.filename});
        });
        // TODO:: утсранить дублирование
        this.curImage = this.items.length > 0 ? '/storage/' + this.elements[0].config.files.medium.filename : null
      });
    },
    components: {
      carousel
    },
    methods: {
      selectSlide: function (id, event) {
        this.elements.forEach(element => {
          if (element.id === id) {
            if(element.figure_id) {
              let config = {
                url: '/files/figure/'+element.id,
                method: 'GET',
                responseType: 'blob'
              }
              axios(config).then(response => {
                let reader = new FileReader();
                reader.readAsDataURL(response.data);
                reader.onload = () => {
                  this.curImage = reader.result;
                }
              }).catch(error => {
                console.log(error)
              })
            }
            // TODO:: устранить дублирование
            this.curImage = '/storage/' + element.config.files.medium.filename;
          }
        });
      }
    }
  }
</script>

