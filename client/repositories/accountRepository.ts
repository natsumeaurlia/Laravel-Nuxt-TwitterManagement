import { NuxtAxiosInstance } from '@nuxtjs/axios'
import { Account } from "~/types/account";

export class AccountRepository {
  constructor(private readonly axios: NuxtAxiosInstance) {}

  public fetchAll() {
    return this.axios.get<Account[]>('api/accounts');
  }
}
