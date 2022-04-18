import { Middleware, Context } from '@nuxt/types'

const fetchAccounts: Middleware = (context: Context) => {
  context.store.dispatch('account/fetchAccounts')
}

export default fetchAccounts
