import { NuxtAxiosInstance } from '@nuxtjs/axios'
import { AxiosResponse } from 'axios'

export class AccountRepository {
  constructor(private readonly axios: NuxtAxiosInstance) {}

  public fetchAll() {
    return this.axios.get('api/tasks')
  }
}
