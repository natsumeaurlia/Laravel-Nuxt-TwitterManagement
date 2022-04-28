<template>
  <div class="">
    <h1>定期タスク新規作成</h1>
    <v-card class="mx-auto px-12 py-12 my-12">
      <v-container>
        <v-row>
          <v-col cols="12" sm="6">
            <h4>タスク名</h4>
            <input-text/>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="6">
            <h4>実行アカウント</h4>
            <v-select
              v-model="select"
              :items="accountList"
              item-text="state"
              item-value="value"
            />
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="6">
            <h4>アクション</h4>
            <v-select
              v-model="select"
              :items="actions"
              item-text="state"
              item-value="value"
            />
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="6">
            <h4>キーワード</h4>
            <input-text/>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="6" md="6">
            <h4>アカウント</h4>
            <div class="d-flex flex-column">
              <input-text label="次のアカウントが送信"/>
              <input-text label="次のアカウント宛"/>
              <input-text label="次のアカウントへの@ツイート"/>
              <v-radio-group v-model="accountFilter">
                <v-radio label="すべてのアカウント" value=""></v-radio>
                <v-radio label="フォローしているアカウント" value="follows"></v-radio>
              </v-radio-group>
            </div>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="6" md="4">
            <h4>日付</h4>
            <div class="d-flex row">
              <date-input v-model="startDate" class="mr-4" label="次の日付以降"/>
              <date-input v-model="endDate" label="次の日付以前"/>
            </div>
          </v-col>
          <v-col cols="12" sm="6" md="4">
            <h4>フィルター</h4>
            <div v-for="select in selects" :key="select" class="d-flex">
              <v-checkbox v-model="selected" :label="description[select]"/>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </v-card>
  </div>
</template>

<script lang="ts">
import {
  computed,
  defineComponent,
  useStore,
} from '@nuxtjs/composition-api'
import { TaskType } from '~/constant/taskType'
import { StoreType } from '~/store/account'
import { filterDescription, FilterOption, filters } from '~/constant/twitterSearch'

interface Selectable {
  state: any
  value: any
}

interface Action {
  state: String
  value: TaskType | ''
}

export default defineComponent({
  components: {},
  layout: 'authenticated',
  middleware: 'fetchAccounts',
  setup() {
    const select: Action = { state: '', value: '' }
    const actions: Action[] = [
      { state: 'フォロー', value: 'follow' },
      { state: 'いいね', value: 'favorite' },
      { state: 'リツイート', value: 'retweet' },
    ]
    const store = useStore<StoreType>()
    const accountList = computed(() =>
      store.state.account.accounts.map((account) => {
        return { state: account.name, value: account.id } as Selectable
      })
    )

    const startDate = ''
    const endDate = ''

    const selects: FilterOption = filters
    const description = filterDescription;
    const selected: [] | FilterOption = []

    const accountFilter = ""

    return {
      select,
      actions,
      accountList,
      startDate,
      endDate,
      selects,
      selected,
      description,
      accountFilter
    }
  },
})
</script>

<style scoped>
h4 {
  margin-bottom: 1rem;
}
</style>
