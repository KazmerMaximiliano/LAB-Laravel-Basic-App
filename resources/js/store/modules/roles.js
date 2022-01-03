const state = {
  roles: null,
  form: {}
}

const mutations = {
  fillRoles(state, roles) {
    state.roles = roles
  },

  fillForm(state, form) {
    state.form = form
  },

  resetForm(state) {
    state.form = {}
  }
}

const actions = {
  index: function ({ commit, dispatch }, params) {
    return new Promise((resolve, reject) => {
      axios
        .get('/api/roles', { params: params })
        .then((response) => {
          commit('fillRoles', response.data)
          resolve(response.data)
        })
        .catch((error) => {
          dispatch('errors/errorHandle', error.response, { root: true })
          reject(error.response)
        })
    })
  },

  save: function ({ state, commit, dispatch }) {
    return new Promise((resolve, reject) => {
      axios
        .post('/api/roles', state.form)
        .then((response) => {
          commit('resetForm')
          resolve(response.data)
        })
        .catch((error) => {
          dispatch('errors/errorHandle', error.response, { root: true })
          reject(error.response)
        })
    })
  },

  edit: function ({ commit }, params) {
    commit('fillForm', params.data)
  },

  update: function ({ state, commit, dispatch }, params) {
    return new Promise((resolve, reject) => {
      axios
        .put('/api/roles/' + params.id, state.form)
        .then((response) => {
          commit('resetForm')

          resolve(response.data)
        })
        .catch((error) => {
          dispatch('errors/errorHandle', error.response, { root: true })
          reject(error.response)
        })
    })
  },

  destroy: function ({ dispatch }, params) {
    return new Promise((resolve, reject) => {
      axios
        .delete('/api/roles/' + params.id)
        .then((response) => {
          resolve(response.data)
        })
        .catch((error) => {
          dispatch('errors/errorHandle', error.response, { root: true })
          reject(error.response)
        })
    })
  }
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}
