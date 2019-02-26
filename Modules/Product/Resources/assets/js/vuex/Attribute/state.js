import module_actions from './actions.js'
import standart_actions from '@/vuex/actions.js'
import module_mutations from './mutations.js'
import standart_mutations from '@/vuex/mutations.js'
import module_getters from './getters.js'
import standart_getters from '@/vuex/getters'

var actions = Object.assign({}, module_actions, standart_actions)
var getters = Object.assign({}, module_getters, standart_getters)
var mutations = Object.assign({}, module_mutations, standart_mutations)

const state = {
  name: 'Attribute',
  items: [],
  url: 'api/attribute',
  item: {},
  bindAttributes: [],
  loading: true,
  needFields: true,
  init: true,
  fields: [],
  model: 'Modules\\Product\\Entities\\Attribute::class',
  relations: [{column:'attribute_group_id',module:'AttributeGroup'}, {column: 'attribute_unit_id', module: 'AttributeUnit'}, {column: 'attribute_type_id', module: 'AttributeType'}]
}

const module = {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}

export default module;

