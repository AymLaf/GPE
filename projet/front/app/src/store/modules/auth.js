import { Storage } from '../../services/Storage'
import { LinkApi } from '../api'
import { ApiAxios } from '../../services/ApiAxios'

const state = {
  stateUser: Storage.get('user') || false
}

const getters = {
  getUser (state) {
    return () => {
      return state.stateUser
    }
  }
}

const actions = {
  login({ commit }, authOption) {
    return ApiAxios.post(LinkApi.login, authOption)
      .then(function(response) {
        if (response != null) {
          Storage.set('user', response.data.user)
          Storage.set('jwt_token', response.data.token)
          ApiAxios.setHeader()
          commit('mutAuth', JSON.parse(response.data.user))
        }
      })
      .catch(function(error) {
        // eslint-disable-next-line no-console
        console.log(error)
      })
  },
  logout({ commit }) {
    commit('mutAuth', false)
    Storage.remove('user')
  },

  changePassword({commit}, passwordOption) {
    return ApiAxios.post(LinkApi.user + '/' + passwordOption.id + '/changepwd' , passwordOption)
      .then(function(response) {
        if (response.data.status === 'success') {
          console.log("password changed successfully")
          return true
        } else {
          return false
        }
      }).catch(function(error) {
        console.log(error)
      })
  },

  checkHash({commit}, hashOption) {
    return ApiAxios.post(LinkApi.checkhash, hashOption)
      .then(function(response) {
        // console.log(response)
        if (response.data.status === 'success') {
          return response.data.data.id
        } else {
          return 0
        }
      }).catch(function(error) {
        return 0
      })
  }
}

const mutations = {
  mutAuth(state, auth) {
    state.stateUser = auth
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
