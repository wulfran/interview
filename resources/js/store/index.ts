import {InjectionKey} from "vue";
import {createStore, Store} from "vuex";
import VuexPersistence from "vuex-persist";

const vuexLocal = new VuexPersistence({
    storage: window.localStorage
})
export interface State {}

export const key: InjectionKey<Store<State>> = Symbol()

export const store = createStore<State>({
    modules: {},
    state: {
        errorBag: null
    },
    getters: {},
    actions: {},
    plugins: [vuexLocal.plugin],
    mutations: {}
})
