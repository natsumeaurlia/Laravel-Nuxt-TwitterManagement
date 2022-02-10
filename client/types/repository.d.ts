import { UserRepository } from "~/repositories/userRepository";

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
  interface Store<S> {
    $userRepository: UserRepository
  }
}
