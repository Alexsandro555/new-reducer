import * as actions from './actions'
import mutations from './mutations'
import getters from './getters'
import initializer from '@initializer/vuex/initializer/state'
import Product from '@product/vuex/Product/state'
import notification from '@/vuex/notification/state'
import Attribute from '@product/vuex/Attribute/state'
import AttributeUnit from '@product/vuex/AttributeUnit/state'
import AttributeGroup from '@product/vuex/AttributeGroup/state'
import ProductCategory from '@product/vuex/ProductCategory/state'
import TypeProduct from '@product/vuex/TypeProduct/state'
import LineProduct from '@product/vuex/LineProduct/state'
import Tnved from '@product/vuex/Tnved/state'
import AttributeListValue from '@product/vuex/AttributeListValue/state'
import Producer from '@product/vuex/Producer/state'
import TradeOffer from '@product/vuex/TradeOffer/state'
import Sku from '@product/vuex/Sku/state'
import SkuOptions from '@product/vuex/SkuOptions/state'
import AttributeType from '@product/vuex/AttributeType/state'
import AttributeValue from '@product/vuex/AttributeValue/state'
import Auth from '@auth/vuex/Auth/state'
import Article from '@article/vuex/state'
import News from '@news/vuex/News/state'
import Page from '@page/vuex/state'
import Attributables from '@product/vuex/Attributables/state'

//const modulesPath = '../../Modules'

let states = [];
const requreModuleVuex = require.context(
  '../../../Modules', true, /state\.js$/
)
requreModuleVuex.keys().forEach(path => {
  let state = path.replace('/state.js', '')
  states.push({'name': state.substring(state.lastIndexOf('/')+1, state.length), 'path': path})
})

//states.forEach(state => {
  //console.log(`../../Modules/${state.path.substring(2, state.path.length)}`)
  /*import(`../../Modules/${state.path.substring(2, state.path.length)}`).then(module => {
    console.log(module)
  })*/
//})

//let temp = states.path[1].substring(2, state.path.length)

/*import(`../../Modules/${temp}`).then(module => {
  console.log(module)
})*/

//

export default function() {
  return {
    modules: {
      initializer,
      notification,
      products: Product,
      product_categories: ProductCategory,
      type_products: TypeProduct,
      tnveds: Tnved,
      line_products: LineProduct,
      producers: Producer,
      attribute_units: AttributeUnit,
      attribute_groups: AttributeGroup,
      attributes: Attribute,
      attribute_types: AttributeType,
      attribute_list_values: AttributeListValue,
      TradeOffer,
      Sku,
      SkuOptions,
      attribute_values: AttributeValue,
      Auth,
      Article,
      news: News,
      pages: Page,
      attributables: Attributables
    },
    mutations,
    getters
  }
}