import axios from "axios/index"

export const api = {
  url: '/attribute',
  get(id) {},
  save(url, data) {
    return new Promise((resolve, reject) => {
      axios.post(url, data).then(response => response.data).then(response => {
        resolve(response)
      })
    }).catch(error => {
      reject(error)
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
  binding() {
    return new Promise((resolve) => {
      axios.get(this.url+'/binding').then(response => response.data).then(response => {
        resolve(response)
      })
    })
  },
  saveBindings(data) {
    return new Promise((resolve) => {
      axios.patch(this.url+'/bindings', data).then(response => response.data).then(response => {
        resolve(response)
      })
    })
  },
  removeBindyAttributes(data) {
    return new Promise((resolve) => {
      axios.patch(this.url+'/remove-bind-attributes', data).then(response => response.data).then(response => {
        resolve(response)
      })
    })
  }
}