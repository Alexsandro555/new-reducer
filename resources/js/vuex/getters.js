import { GLOBAL } from "@/constants"

export default {
  items: state => state.items,
  [GLOBAL.GET_ITEM]: (state, commit) => (id) => {
    return state.items.find(item => item.id == id)
  },
  [GLOBAL.TRANSFORM_BY_KEY]: (state, getters, rootState, rootGetters) => (obj, key) => {
    if (!_.isObject(obj)) { obj=_.isNil(state.items)?{}:state.items.find(item => item[getters.primary_key]==obj) }
    if (_.isNil(getters.config.upLinks)) {return {}}
    var uplink=getters.config.upLinks.find(item => item.column==key)
    if (_.isNil(uplink)) {
      return {}
    }
    var link=rootGetters[uplink.module+'/items'].find(item => item[rootGetters[uplink.module+'/primary_key']]==_.get(obj,key))
    return (_.isNil(link))?{}:link
  }
}