export const mutations = {
    submitButtonLoadingStatus(state, payload) {
        state.isSubmitButtonLoading = payload
    },
    supportingData(state, payload) {
    },
    me(state, payload) {
        state.me = payload
    },
    particulars(state, payload) {
        state.particulars = payload
    },
    eStatement(state, payload) {
        state.eStatement = payload
    },
    closingDate(state,value) {
        this.state.closingDate = value
    }
}
