export default{
  state: {
    isLoading: false,
    error: false,
    errorMsg: ""
  },
  getters: {
    isLoading(state) {
      return state.isLoading
    },
    error(state) {
      return state.error
    },
    errorMsg(state) {
      return state.errorMsg
    }
  },
  mutations: {
    TOGGLE_LOADING (state, payload) {
      state.isLoading = payload;
    },
    TOGGLE_ERROR (state, payload) {
      state.error = payload;
    },
    SET_ERRORMSG (state, payload) {
      state.errorMsg = payload;
    }
  },
  actions: {}
}
