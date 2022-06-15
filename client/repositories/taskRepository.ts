import { NuxtAxiosInstance } from '@nuxtjs/axios'
import { AxiosResponse } from 'axios'
import { Account } from '~/types/account'
import { CreateTask } from '~/types/task'

export class TaskRepository {
  constructor(private readonly axios: NuxtAxiosInstance) {}

  public fetchAll() {
    return this.axios.get('api/tasks')
  }

  public store(form: CreateTask): Promise<AxiosResponse<Account>> {
    return this.axios.post<Account>('api/tasks', {
      account_id: form.selectedAccount,
      name: form.taskName,
      type: form.selectedAction,
      execution_interval: form.interval,
      is_enable: form.isEnable,
      keyword: form.keyword,
      start_time_period: form.startTimePeriod,
      end_time_period: form.endTimePeriod,
      max_execution: form.maxExecution,
      range_min_sleep_time: form.minSleep,
      range_max_sleep_time: form.minSleep,
    })
  }
}
