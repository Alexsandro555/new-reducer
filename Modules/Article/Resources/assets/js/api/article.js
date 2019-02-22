import axios from "axios/index"

export const articleApi = {
    url: '/article',
    patch(data) {
        return new Promise((resolve, reject) => {
            axios.patch(this.url, data).then(response => response.data).then(response => {
                resolve(response)
            }).catch(error => {
                reject(error)
            })
        })
    },
    getDefault() {
        return new Promise((resolve, reject) => {
            axios.get(this.url+'/default').then(response => response.data).then(response => {
                resolve(response)
            }).catch(error => {
                reject(error)
            })
        })
    }
}