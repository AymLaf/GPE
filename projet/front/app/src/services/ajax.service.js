import ToastrService from "./toastr.service";
import store from "../store";
import Qs from 'qs';

const AjaxService = {
    handleBeforeRequest(request) {
        store.dispatch('loading/process');
        request.withCredentials = true;
        request.paramsSerializer = params => {
            return Qs.stringify(params, {
                arrayFormat: "index",
                encode: false
            });
        };

        return request;
    },
    handleResponseRejected(error) {
        store.dispatch('loading/stopProcessing');
        if (error) {
            if (error.response) {
                let p = this.handleStatusCode(error.response.status, error);

                if (p === null && error.response.data) {
                    if (error.response.data instanceof Array) {
                        ToastrService.error('"' + error.response.data[0].property_path + '" : ' + error.response.data[0].message);
                    } else {
                        ToastrService.error(error.response.data.message);
                    }
                } else {
                    return p;
                }

            } else if (error.message) {
                ToastrService.error(error.message);
            }
        }
        return Promise.reject(error)
    },

    handleStatusCode(code, error) {
        if (code === 401) {
            if (error.config) {
                if (error.config.url.includes('/refresh-token') || error.config.url.includes('/login_check')) {
                    // Refresh token has failed. Logout the user
                    //store.dispatch('auth/logout');
                } else {
                    // Refresh the access token
                    return store.dispatch('auth/refreshToken').then(() => {
                        return this.request({
                            method: error.config.method,
                            url: error.config.url,
                            data: error.config.data,
                            params: error.config.params
                        })
                    });
                }
            } else {
                store.dispatch('auth/logout');
            }
        }
        if (code === 403) {
            store.dispatch('auth/logout');
        }
        return null;
    }
};

export default AjaxService;