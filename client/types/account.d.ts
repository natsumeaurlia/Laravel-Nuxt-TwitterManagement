export interface Account {
  id: String
  name: String
  screen_name: String
  avatar_path: String
  created_at: Date
}

export interface CreateAccountArg {
  token: String
  tokenSecret: String
  consumerKey: String
  consumerSecret: String
}
