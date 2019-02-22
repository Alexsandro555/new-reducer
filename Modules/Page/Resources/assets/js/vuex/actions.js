import { ACTIONS } from "@page/constants"
import { GLOBAL } from "@/constants"

import axios from "axios/index";
import { api } from "@page/../api/index";

export default {
    [ACTIONS.SAVE_DATA]: ({state, dispatch}) => {
        api.patch(state.item)
            .then(response => {
                dispatch('successSaveNotification', response.message, {root: true})
            })
    }
}