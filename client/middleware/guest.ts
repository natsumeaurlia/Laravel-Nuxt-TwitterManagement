import { Middleware,Context } from "@nuxt/types";

const redirectTo = '/'

const myMiddleware: Middleware = (context: Context) => {
  if (context.app.$auth.$state.loggedIn) {
    return context.redirect(redirectTo)
  }
}

export default myMiddleware
