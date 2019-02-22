import { ACTIONS, PRIVATE, GLOBAL } from "@/constants"
import axios from "axios/index";
import { articleApi } from "@article/api/article";

export default {
    [ACTIONS.SAVE_DATA]: ({state, dispatch, commit}) => {
        articleApi.patch(state.item)
            .then(response => {
                dispatch('successSaveNotification', response.message, {root: true})
            })
    }
}