import { UserRepository } from '~/repositories/userRepository'
import { AccountRepository } from '~/repositories/accountRepository'

declare module 'vue/types/vue' {
  interface Vue {
    $userRepository: UserRepository
    $accountRepository: AccountRepository
  }
}
declare module '@nuxt/types' {
  interface NuxtAppOptions {
    $userRepository: UserRepository
    $accountRepository: AccountRepository
  }
}

declare module 'vuex/types/index' {
  // eslint-disable-next-line @typescript-eslint/no-unused-vars
  interface Store<S> {
    $userRepository: UserRepository
    $accountRepository: AccountRepository
  }
}
