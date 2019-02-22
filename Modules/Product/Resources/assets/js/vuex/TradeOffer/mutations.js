import { PRIVATE } from "@product/constants";

export default {
    [PRIVATE.SAVE]: (state, payload) => {
      state.items.push(payload)
    }
}
