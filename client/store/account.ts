import { GetterTree, ActionTree, MutationTree } from 'vuex'
import { Account, CreateAccountArg } from '~/types/account'

export interface State {
  accounts: Account[]
}

export interface StoreType {
  account: State
}

export const state = (): State => ({
  accounts: [] as Account[],
})

export type RootState = ReturnType<typeof state>

export const getters: GetterTree<RootState, RootState> = {
  accountIds: (state): Set<number | unknown> => {
    const ids = new Set()
    state.accounts.map((account) => ids.add(account.id))
    return ids
  },
}

export const mutations: MutationTree<RootState> = {
  SET_ACCOUNTS: (state, accounts: Account[]) => (state.accounts = accounts),
  ADD_ACCOUNT: (state, account: Account) => state.accounts.push(account),
  DELETE_ACCOUNT: (state, id: string) => {
    const index = state.accounts.findIndex((account) => account.id === id)
    state.accounts.splice(index, 1)
  },
}

export const actions: ActionTree<RootState, RootState> = {
  async fetchAccounts({ commit }) {
    try {
      const { data } = await this.$accountRepository.fetchAll()
      commit('SET_ACCOUNTS', data)
    } catch (err) {
      // todo: エラーメッセージの表示
    }
  },
  async createAccounts(
    { commit, getters },
    { token, tokenSecret, consumerKey, consumerSecret }: CreateAccountArg
  ) {
    try {
      const { data } = await this.$accountRepository.store(
        token,
        tokenSecret,
        consumerKey,
        consumerSecret
      )
      if (!getters.accountIds.has(data.id)) {
        commit('ADD_ACCOUNT', data)
      }
    } catch (err) {
      // todo: エラーメッセージの表示
    }
  },
  async deleteAccount({ commit }, id: string) {
    try {
      await this.$accountRepository.destroy(id)
      commit('DELETE_ACCOUNT', id)
    } catch (err) {
      // todo: エラーメッセージの表示
    }
  },
}
