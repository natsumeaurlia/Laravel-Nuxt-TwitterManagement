import { GetterTree, ActionTree, MutationTree } from 'vuex'
import { Account } from "~/types/account";

export interface State {
  accounts: Account[]
}

export interface StoreType{
  account: State
}

export const state = (): State => ({
  accounts: [] as Account[],
})

export type RootState = ReturnType<typeof state>

export const getters: GetterTree<RootState, RootState> = {}

export const mutations: MutationTree<RootState> = {
  SET_ACCOUNTS: (state, accounts: Account[]) => (state.accounts = accounts),
}

export const actions: ActionTree<RootState, RootState> = {
  async fetchAccounts({ commit }) {
    try {
      const { data } = await this.$accountRepository.fetchAll();
      commit('SET_ACCOUNTS', data)
    } catch (err) {
      // todo: エラーメッセージの表示
    }
  },
}
