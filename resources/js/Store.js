import Vuex from "vuex";

const state = {
    token: null,
    users: [],
    listings: [],
    casinos: [],
};

const mutations = {
    updateStore(state, payload) {
        state[payload.data] = payload.value;
    },

    updateSingleUserInStore(state, payload) {
        state.users[payload.index] = payload.value;
    },

    deleteSingleUser(state, index) {
        state.users.splice(index, 1);
    },
};

export default new Vuex.Store({
    state,
    mutations,
});
