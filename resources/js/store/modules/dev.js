const state = {
    response: null,
    items: null,
};

const mutations = {
    fillResponse(state, response) {
        state.response = response;
    },

    fillItems(state, items) {
        state.items = items;
    },
};

const actions = {
    get: function({ commit, dispatch }, params) {
        return new Promise((resolve, reject) => {
            axios
                .get(params.route, params.params)
                .then(response => {
                    if(response.data) {
                        commit("fillItems", response.data);
                    }
                    commit("fillResponse", response);
                    resolve(response);
                })
                .catch(error => {
                    commit("fillResponse", error);
                    reject(error.response);
                });
        });
    },

    post: function({ commit, dispatch }, params) {
        return new Promise((resolve, reject) => {
            axios
                .post(params.route, params.params)
                .then(response => {
                    commit("fillResponse", response);
                    resolve(response);
                })
                .catch(error => {
                    commit("fillResponse", error);
                    reject(error.response);
                });
        });
    },

    put: function({commit,  dispatch }, params) {
        return new Promise((resolve, reject) => {
            axios
                .put(params.route, params.params)
                .then(response => {
                    commit("fillResponse", response);
                    resolve(response);
                })
                .catch(error => {
                    commit("fillResponse", error);
                    reject(error.response);
                });
        });
    },

    delete: function({ commit, dispatch }, params) {
        return new Promise((resolve, reject) => {
            axios
                .delete(params.route, params.params)
                .then(response => {
                    commit("fillResponse", response);
                    resolve(response);
                })
                .catch(error => {
                    commit("fillResponse", error);
                    reject(error.response);
                });
        });
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    actions
};