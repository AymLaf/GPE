import StorageService from '../../services/storage.service'
import RouterService from '../../services/router.service'
import { ApiEndpoints } from '../../router/api.endpoints'
import { ApiAxios } from '../../services/axios.service'

const state = {
    stateUser: StorageService.get('user') || false
};

const getters = {
    getUser (state) {
        return () => {
            return state.stateUser
        }
    }
};

const actions = {
    login({ commit }, authOption) {
        console.log(authOption);
        return ApiAxios.post(ApiEndpoints.login, authOption)
            .then(function(response) {
                if (response != null) {
                    StorageService.set('auth_user', response.data.user);
                    //StorageService.set('jwt_token', response.data.token);
                    StorageService.set('refresh_token', response.data.refresh_token);
                    ApiAxios.setHeader();
                    commit('mutAuth', null);
                    RouterService.getRouter().push({name: 'Dashboard'});
                }
            })
            .catch(function(error) {
                // eslint-disable-next-line no-console
                console.log(error);
            })
    },
    logout({ commit }) {
        StorageService.clear();
        commit('mutAuth', null);
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
