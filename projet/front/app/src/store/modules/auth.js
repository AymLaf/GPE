import StorageService from '../../services/storage.service'
import RouterService from '../../services/router.service'
import { ApiEndpoints } from '../../router/api.endpoints'
import { ApiAxios } from '../../services/axios.service'

const state = {
    stateUser: StorageService.get('auth_user') || {}
};

const getters = {
    getUser: (state) => state.stateUser
};

const actions = {
    login({ commit }, authOption) {
        return ApiAxios.post(ApiEndpoints.login, authOption)
            .then(function(response) {
                if (response != null) {
                    StorageService.set('auth_user', response.data.user);
                    StorageService.set('refresh_token', response.data.refresh_token);
                    ApiAxios.setHeader();
                    commit('mutAuth', response.data.user);
                    RouterService.getRouter().push({name: 'Dashboard'});
                }
            })
            .catch(function() {
                //add error parameter if you want
                // eslint-disable-next-line no-console
                //console.log(error);
            })
    },
    getAllUsers() {
        return ApiAxios.get(ApiEndpoints.users)
            .then(function (response) {
                console.log(response);
            })
    },
    logout({ commit }) {
        StorageService.clear();
        commit('mutAuth', {});
        RouterService.getRouter().push({name: 'Login'});
    },
};

const mutations = {
    mutAuth(state, auth) {
        state.stateUser = auth;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
