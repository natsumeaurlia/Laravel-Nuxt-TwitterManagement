// eslint-disable-next-line import/named
import { NuxtAxiosInstance } from '@nuxtjs/axios'

export class UserRepository {
  constructor(private readonly axios: NuxtAxiosInstance) {}

  public store(name: string, email: string, password: string) {
    return this.axios.post('/api/v1/auth/register', { name, email, password })
  }
}
