import { ACTIONS } from "@page/constants"
import { api } from "@page/../api/index";

export default {
    [ACTIONS.SAVE_DATA]: ({state, dispatch}) => {
        api.patch(state.item)
            .then(response => {
                dispatch('successSaveNotification', response.message, {root: true})
            })
    }
}