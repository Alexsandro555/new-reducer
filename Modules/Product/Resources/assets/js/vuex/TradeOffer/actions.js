import { GLOBAL } from "@/constants";
import { ACTIONS, PRIVATE } from "@product/constants"
import { api } from "../../api/TradeOffer";

export default {
    [ACTIONS.SAVE_DATA]: ({commit, state},data) => {
        api.post({'url': state.url, data}).then(response => {
            commit(PRIVATE.SAVE, response)
        })
    }
}