import router from '../../routes'

const state = {
  errors: []
}

const mutations = {
  fillErrors(state, error) {
    state.errors.push(error)
    window.scrollTo(0, 0)
  },

  deleteError(state, error) {
    let index = state.errors.indexOf(error)
    state.errors.splice(index, 1)
  },

  resetErrors(state) {
    state.errors = []
  }
}

const actions = {
  errorHandle({ commit, dispatch }, errors) {
    if (errors) {
      if (errors.status == 401) {
        dispatch('auth/deleteAuthData', {}, { root: true })
        router.push('/')
      } else if (errors.status == 403) {
        router.push('/accessd_denied')
      } else {
        let error = {
          config: errors.config,
          data: errors.data,
          status: errors.status
        }

        commit('fillErrors', error)
      }
    }
  }
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}
