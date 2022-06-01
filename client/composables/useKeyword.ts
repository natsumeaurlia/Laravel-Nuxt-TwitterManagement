import { computed, reactive, ref } from '@nuxtjs/composition-api'
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

export const useKeyword = () => {
  const keyword = ref('')
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

  const encodeOption = computed(() => {
    let key = keyword.value.trim()
    if (keyOption.keywordType === 'or') {
      key = key
        ? splitBlank(key)
            .map((text) => `"${text}"`)
            .join(' OR ')
        : key
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
  return { keyword, keyOption, encodeOption, splitBlank }
}
