const TASK_TYPE = {
  FOLLOW : 'follow',
  FAVORITE: 'favorite',
  RETWEET: 'retweet',
  UNFOLLOW: 'unfollow',
} as const

export type TaskType = typeof TASK_TYPE[keyof typeof TASK_TYPE]
