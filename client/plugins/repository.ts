import { Inject, NuxtApp } from "@nuxt/types/app";

import { apiRepositoryFactory, Repositories } from "../composables/repositoryFactory";

export default ({ app }: { app: NuxtApp }, inject: Inject) => {
  const repositories = (name: keyof Repositories) => {
    return new (apiRepositoryFactory.get(name))(app.$axios);
  };

  inject("repositories", repositories);
}
