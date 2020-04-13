import axios from 'axios'
import StorageService from './storage.service'
import AjaxService from './ajax.service'
import store from "../store";


export const ApiAxios = {

    init(baseURL) {
        axios.defaults.baseURL = baseURL;
        axios.defaults.withCredentials = true;
        this.setHeader();
        this.mountInterceptor();
    },

    setHeader() {
        if (StorageService.get('jwt_token')) {
            console.log(StorageService.get('jwt_token'));
            //axios.defaults.headers.common["Authorization"] = `Bearer ${StorageService.get('jwt_token')}`
        }
    },

    removeHeader() {
        axios.defaults.headers.common = {}
    },

    get(resource, payload) {
        return axios.get(resource, { params: payload, withCredentials: true })
    },

    post(resource, data) {
        return axios.post(resource, data, { withCredentials: true })
    },

    put(resource, data) {
        return axios.put(resource, data)
    },

    delete(resource, payload) {
        return axios.delete(resource, { params: payload })
    },

    /**
     * Perform a custom Axios request.
     *
     * data is an object containing the following properties:
     *  - method
     *  - url
     *  - data ... request payload
     *  - auth (optional)
     *    - username
     *    - password
     **/
    request(data) {
        return axios(data)
    },

    mountInterceptor() {

        this._requestInterceptor = axios.interceptors.request.use(function (request) {
            // Do something before request is sent
            //console.log("Request interceptor");
            request =  AjaxService.handleBeforeRequest(request);
            return request;
        }, function (error) {
            // Do something with request error
            //console.log("Request interceptor error");
            store.dispatch('loading/stopProcessing');
            return Promise.reject(error);
        });

        this._responseInterceptor = axios.interceptors.response.use(function (response) {
            // Any status code that lie within the range of 2xx cause this function to trigger
            // Do something with response data
            //console.log("Response interceptor");
            store.dispatch('loading/stopProcessing');
            //console.log(response);
            return response;
        }, function (error) {
            // Any status codes that falls outside the range of 2xx cause this function to trigger
            // Do something with response error
            //console.log("Response interceptor error");
            store.dispatch('loading/stopProcessing');
            //console.log(error.response);
            //return Promise.reject(error);
            return AjaxService.handleResponseRejected(error);
        });
    },

    unmountInterceptor() {
        // Eject the interceptor
        axios.interceptors.response.eject(this._requestInterceptor);
        axios.interceptors.response.eject(this._responseInterceptor);
    }
};
