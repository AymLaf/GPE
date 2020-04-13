const state = {
    loading: false
};

const getters = {
    isLoading: state => state.loading,
};

const mutations = {
    ['LOADING_START'](state) {
        state.loading = true;
    },
    ['LOADING_STOP'](state) {
        state.loading = false;
    },
};

const actions = {
    process({commit}) {
        if (!state.loading) {
            commit('LOADING_START');
        }
    },
    stopProcessing({commit}) {
        if (state.loading) {
            commit('LOADING_STOP');
        }
    }
};

export default {
    namespaced: true, state, getters, mutations, actions
}
