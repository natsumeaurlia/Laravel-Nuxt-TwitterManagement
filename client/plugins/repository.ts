import { Inject, NuxtApp } from '@nuxt/types/app'
import { UserRepository } from '~/repositories/userRepository'
import { AccountRepository } from '~/repositories/accountRepository'

export default ({ app }: { app: NuxtApp }, inject: Inject) => {
  const userRepository = new UserRepository(app.$axios)
  const accountRepository = new AccountRepository(app.$axios)

  inject('userRepository', userRepository)
  inject('accountRepository', accountRepository)
}
