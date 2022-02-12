import { Inject, NuxtApp } from '@nuxt/types/app'
import { UserRepository } from '~/repositories/userRepository'

export default ({ app }: { app: NuxtApp }, inject: Inject) => {
  const userRepository = new UserRepository(app.$axios)

  inject('userRepository', userRepository)
}
