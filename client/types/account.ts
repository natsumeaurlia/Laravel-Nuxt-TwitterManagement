export interface Account {
  id: string
  name: string
  screen_name: string
  avatar_path: string
  created_at: Date
}

export interface CreateAccountArg {
  token: string
  tokenSecret: string
  consumerKey: string
  consumerSecret: string
}
