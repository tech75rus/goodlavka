import { createStore } from 'vuex'

export default createStore({
  state: {
    auth: false
  },
  getters: {
    getAuth(state) {
      return state.auth;
    }
  },
  mutations: {
    changeAuth(store){
      store.auth = true;
    }
  },
  actions: {
  },
  modules: {
  }
})
