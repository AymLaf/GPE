import axios from 'axios'
import {Storage} from './Storage'

export const ApiAxios = {

  init(baseURL) {
    axios.defaults.baseURL = baseURL;
    this.setHeader();
  },

  setHeader() {
    if (Storage.get('jwt_token')) {
      axios.defaults.headers.common["Authorization"] = `Bearer ${Storage.get('jwt_token')}`
    }
  },

  removeHeader() {
    axios.defaults.headers.common = {}
  },

  get(resource, payload) {
    return axios.get(resource, { params: payload })
  },

  post(resource, data) {
    return axios.post(resource, data)
  },

  put(resource, data) {
    return axios.put(resource, data)
  },

  delete(resource, payload) {
    return axios.delete(resource, { params: payload })
  }
}
