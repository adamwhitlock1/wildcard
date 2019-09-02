const state = {
  itemList: ["Item 1", "Item 2"],
}

const getters = {
  getItems: (state, getters, rootState) => {
    return state.itemList
  }
}

const mutations = {
  addItem(state, item) {
    console.log(item + " Should be added to list.");
    state.itemList.push(item)
  },
  removeItem(state, index) {
    state.itemList.splice(index, 1)
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations
}