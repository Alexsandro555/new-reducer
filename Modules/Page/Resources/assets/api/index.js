import axios from "axios/index"

export const api = {
    url: '/page',
    get() {
        return new Promise((resolve, reject) => {
            axios.get(this.url).then(response => response.data).then(response => {
                resolve(response)
            }).catch(error => {
                reject(error)
            })
        })
    },
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