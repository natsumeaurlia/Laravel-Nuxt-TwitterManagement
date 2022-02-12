import { UserRepository } from '~/repositories/userRepository'

declare module 'vue/types/vue' {
  interface Vue {
    $userRepository: UserRepository
  }
}
declare module '@nuxt/types' {
  interface NuxtAppOptions {
    $userRepository: UserRepository
  }
}

declare module 'vuex/types/index' {
  // eslint-disable-next-line @typescript-eslint/no-unused-vars
  interface Store<S> {
    $userRepository: UserRepository
  }
}
