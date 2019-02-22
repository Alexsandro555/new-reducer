import {GETTERS} from '@product/constants'

export default {
  [GETTERS.BY_PRODUCT_ID]: (state, commit) => (id) => {
    return state.items.filter(item => item.product_id == id)
  }
}