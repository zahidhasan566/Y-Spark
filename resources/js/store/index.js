import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);
import actions from './actions'
import getters from './getters'
import {mutations} from './mutations'

const state = {
    isSubmitButtonLoading: false,
    status:[],
    me: {},
    particulars: [],
    eStatement: [],
    closingDate: ''
}

export default new Vuex.Store({
    namespaced: true,
    state,
    getters,
    mutations,
    actions
})
