import { NuxtAxiosInstance } from '@nuxtjs/axios'
import { AxiosResponse } from 'axios'
import { TaskForm, Task } from '~/types/task'

const JsonBigInt = require('json-bigint')

export class TaskRepository {
  constructor(private readonly axios: NuxtAxiosInstance) {
  }

  public fetchAll(): Promise<AxiosResponse<Task[]>> {
    return this.axios.get<Task[]>('api/tasks', {
      transformResponse: (data) => JsonBigInt.parse(data),
    })
  }

  public fetch(id: String): Promise<AxiosResponse<Task| null>> {
    return this.axios.get<Task|null>('api/tasks/' + id, {
      transformResponse: (data) => JsonBigInt.parse(data),
    })
  }

  public store(form: TaskForm): Promise<AxiosResponse<Task>> {
    return this.axios.post<Task>('api/tasks', {
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
    }, {
      transformResponse: (data) => JsonBigInt.parse(data),
    })
  }

  public destroy(id: string) {
    return this.axios.delete('api/tasks/' + id)
  }
}
