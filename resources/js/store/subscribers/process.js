export function process(store) {
  store.subscribeAction({
    before: (action) => {
      store.commit('iterateProcess', true)
    },
    after: (action) => {
      store.commit('iterateProcess', false)
    }
  })
}
