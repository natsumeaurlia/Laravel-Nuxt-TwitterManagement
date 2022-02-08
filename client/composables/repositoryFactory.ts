import { UserRepository } from "../repositories/userRepository";

export interface Repositories {
  user: typeof UserRepository
}

const repositories: Repositories = {
  user: UserRepository,
}

export const apiRepositoryFactory = {
  get: (key: keyof Repositories) => repositories[key]
}
