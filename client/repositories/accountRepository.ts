import { NuxtAxiosInstance } from '@nuxtjs/axios'
import { AxiosResponse } from 'axios'
import { Account } from '~/types/account'

const JsonBigInt = require('json-bigint')

export class AccountRepository {
  constructor(private readonly axios: NuxtAxiosInstance) {}

  public fetchAll(): Promise<AxiosResponse<Account[]>> {
    return this.axios.get<Account[]>('api/accounts', { transformResponse: data => JsonBigInt.parse(data) })
  }

  public store(
    token: String,
    tokenSecret: String,
    consumer: String,
    consumerSecret: String
  ): Promise<AxiosResponse<Account>> {
    return this.axios.post<Account>('api/accounts', {
      accessToken: token,
      accessTokenSecret: tokenSecret,
      consumerKey: consumer,
      consumerSecret,
    })
  }

  public destroy(id: String) {
    return this.axios.delete('api/accounts/' + id)
  }
}
