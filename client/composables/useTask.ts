import { computed, reactive, ref } from '@nuxtjs/composition-api'
import { Task, TaskForm } from '~/types/task'
import { YYYYMMDD } from '~/types/date'
import { FilterOption } from '~/constant/twitterSearch'

interface Option {
  excludeKey: string
  keywordType: 'and' | 'or'
  containHashTag: string
  startDate: YYYYMMDD | null
  endDate: YYYYMMDD | null
  filterSelected: [] | FilterOption
  minReply: number | null
  minFavorite: number | null
  minRetweet: number | null
  accountFilter: '' | 'follows'
  fromAccount: string
  toAccount: string
  mentionTo: string
}

function splitBlank(text: string) {
  const replacedText = text.replaceAll('　', ' ')
  return replacedText.split(' ')
}

export const useTask = () => {
  const inputKeyword = ref('')
  const keyOption = reactive<Option>({
    excludeKey: '',
    keywordType: 'and',
    containHashTag: '',
    startDate: null,
    endDate: null,
    filterSelected: [],
    minReply: null,
    minFavorite: null,
    minRetweet: null,
    accountFilter: '',
    fromAccount: '',
    mentionTo: '',
    toAccount: '',
  })

  const encodedKey = computed(() => {
    let key = inputKeyword.value.trim()
    if (key && keyOption.keywordType === 'or') {
      key = splitBlank(key)
        .map((text) => `"${text}"`)
        .join(' OR ')
    } else {
      key = key ? `"${key}"` : key
    }

    key = keyOption.toAccount ? `${key} to:${keyOption.toAccount}` : key
    key = keyOption.fromAccount ? `${key} from:${keyOption.minRetweet}` : key
    key = keyOption.startDate ? `${key} since:${keyOption.startDate}` : key
    key = keyOption.endDate ? `${key} until:${keyOption.endDate}` : key
    key = keyOption.minReply ? `${key} min_retweets:${keyOption.minReply}` : key
    key = keyOption.minFavorite
      ? `${key} min_faves:${keyOption.minFavorite}`
      : key
    key = keyOption.minRetweet
      ? `${key} min_retweets:${keyOption.minRetweet}`
      : key
    key = keyOption.accountFilter ? `${key} filter:follows` : key

    let exclude = ''
    if (keyOption.excludeKey) {
      exclude = splitBlank(keyOption.excludeKey)
        .map((text) => `-"${text}"`)
        .join(' ')
      key = `${key} ${exclude}`
    }

    if (keyOption.mentionTo) {
      key = keyOption.mentionTo.startsWith('@')
        ? `${key} ${keyOption.mentionTo}`
        : `${key} @${keyOption.mentionTo}`
    }

    if (keyOption.filterSelected.length) {
      const filters = keyOption.filterSelected
        .map((text) => `filter:${text}`)
        .join(' ')
      key = `${key} ${filters}`
    }

    if (keyOption.containHashTag) {
      const hash = splitBlank(keyOption.containHashTag)
        .map((text) => (text.startsWith('#') ? text : `#${text}`))
        .join()
      key = `${key} ${hash}`
    }

    return key
  })

  const decodeKeyword = (keyword: string) => {
    // const splitKeyword = keyword.split(' ')
    // splitKeyword.forEach((value) => {
    //   keyOption.toAccount = value.includes('to:') ? value.replace('to:') : txt
    // })
    // console.log(splitKeyword)
    return keyword
  }

  const defaultTask: TaskForm = {
    taskName: '',
    selectedAction: '',
    selectedAccount: '',
    keyword: encodedKey,
    isEnable: true,
    startTimePeriod: '10:00',
    endTimePeriod: '19:00',
    interval: 5,
    maxExecution: 10,
    minSleep: 1,
    maxSleep: 10,
  }

  const makeTask = (obj: Task | null = null) => {
    if (!obj) {
      return reactive<TaskForm>(defaultTask)
    }

    return reactive<TaskForm>({
      taskName: obj.name,
      selectedAction: obj.type,
      selectedAccount: obj.account.id,
      keyword: obj.keyword,
      isEnable: obj.is_enable,
      startTimePeriod: obj.start_time_period,
      endTimePeriod: obj.end_time_period,
      interval: obj.execution_interval,
      minSleep: obj.range_min_sleep_time,
      maxSleep: obj.range_max_sleep_time,
      maxExecution: obj.max_execution,
    })
  }

  const canSubmit = (task: TaskForm) =>
    computed(() => {
      return Object.values(task).every((value) => Boolean(value))
    })

  return { makeTask, canSubmit, inputKeyword, keyOption, splitBlank }
}
