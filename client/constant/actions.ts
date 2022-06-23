import { TaskType } from "~/types/taskType";

interface Action {
  state: string
  value: TaskType | ''
}

export const actions: Action[] = [
  { state: 'フォロー', value: 'follow' },
  { state: 'いいね', value: 'favorite' },
  { state: 'リツイート', value: 'retweet' },
]
