<template>
  <div>
    <h1>ダッシュボード</h1>
    <v-container class="mt-16">
      <v-row>
        <v-col cols="12" sm="6" lg="3">
          <material-stats-card
            color="primary"
            icon="mdi-account-multiple"
            title="アカウント数"
            :value="accountCounts"
          />
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script lang="ts">
import {
  computed,
  defineComponent,
  useFetch,
  useStore,
} from '@nuxtjs/composition-api'
import { StoreType } from '~/store/account'

export default defineComponent({
  layout: 'authenticated',
  setup() {
    const store = useStore<StoreType>()
    useFetch(() => {
      if (store.state.account.accounts.length === 0) {
        store.dispatch('account/fetchAccounts')
      }
    })
    const accountCounts = computed(() => store.state.account.accounts.length)
    return { accountCounts }
  },
})
</script>

<style scoped></style>
