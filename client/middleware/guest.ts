import { Middleware, Context } from '@nuxt/types'

const redirectTo = '/dashboard'

const onlyGuest: Middleware = (context: Context) => {
  if (context.app.$auth.$state.loggedIn) {
    return context.redirect(redirectTo)
  }
}

export default onlyGuest
