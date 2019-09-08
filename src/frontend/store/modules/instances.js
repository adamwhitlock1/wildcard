const state = {
  activeInstance: {
    instanceId: "",
    activePanels: []
  }
};

const getters = {
  activeInstance: (state) => {
    return state.activeInstance;
  }
};

const mutations = {
  setActiveInstancePanels(state, data) {
    console.log("Set active instance panels: ");
    console.log(data);
    state.activeInstance.instanceId = data.instanceId;
    state.activeInstance.activePanels = data.activePanels;
  }
};

export default {
  namespaced: true,
  state,
  getters,
  mutations
}
