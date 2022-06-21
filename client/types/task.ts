import { ComputedRef } from '@nuxtjs/composition-api'
import { TaskType } from '~/types/taskType'
import { Hi } from '~/types/time'
import { Account } from '~/types/account'

export interface Task {
  id: string
  name: string
  keyword: string
  start_time_period: Hi
  end_time_period: Hi
  max_execution: number
  execution_interval: number
  range_min_sleep_time: number
  range_max_sleep_time: number
  type: TaskType
  is_enable: boolean
  account: Account
  created_at: string
  updated_at: string
}

export interface TaskForm {
  taskName: string
  selectedAction: TaskType | ''
  selectedAccount: string | object
  keyword: string | ComputedRef<string>
  minSleep: number
  maxSleep: number
  interval: number
  isEnable: boolean
  maxExecution: number
  startTimePeriod: Hi
  endTimePeriod: Hi
}
