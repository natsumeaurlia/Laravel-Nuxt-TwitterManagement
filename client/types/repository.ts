import { UserRepository } from '~/repositories/userRepository'
import { AccountRepository } from '~/repositories/accountRepository'
import { TaskRepository } from '~/repositories/taskRepository'

declare module 'vue/types/vue' {
  interface Vue {
    $userRepository: UserRepository
    $accountRepository: AccountRepository
    $taskRepository: TaskRepository
  }
}
declare module '@nuxt/types' {
  interface NuxtAppOptions {
    $userRepository: UserRepository
    $accountRepository: AccountRepository
    $taskRepository: TaskRepository
  }
  interface Context {
    $userRepository: UserRepository
    $accountRepository: AccountRepository
    $taskRepository: TaskRepository
  }
}

declare module 'vuex/types/index' {
  // eslint-disable-next-line @typescript-eslint/no-unused-vars
  interface Store<S> {
    $userRepository: UserRepository
    $accountRepository: AccountRepository
    $taskRepository: TaskRepository
  }
}
