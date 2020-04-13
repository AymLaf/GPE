import Vue from 'vue'
import Vuex from 'vuex'

/* Models */
import auth from './modules/auth.js';
import loading from './modules/loading.js';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth, loading
    }
})
