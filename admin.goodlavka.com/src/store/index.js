import Vue from 'vue'
import Vuex from 'vuex'
import axios from "axios";
import {host} from "../service/host";

Vue.use(Vuex)

export default new Vuex.Store({
  actions: {
    actionLoader(ctx) {
      ctx.commit('changeLoader');
    },
    actionLoginIn({commit}) {
      commit('changeLoginIn');
    }
  },
  mutations: {
    changeLoader(state) {
      state.loader = false;
    },
    changeLoginIn(state) {
      state.loginIn = true;
    }
  },
  state: {
    loader: true,
    loginIn: false
  },
  getters: {
    getLoader(state) {
      return state.loader;
    },
    getLoginIn(state) {
      return state.loginIn;
    }
  }
})
