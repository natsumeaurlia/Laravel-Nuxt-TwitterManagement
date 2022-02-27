// eslint-disable-next-line import/named
import { NuxtAxiosInstance } from '@nuxtjs/axios'

export class UserRepository {
  constructor(private readonly axios: NuxtAxiosInstance) {}

  public store(name: String, email: String, password: String) {
    return this.axios.post('/api/auth/register', { name, email, password })
  }
}
