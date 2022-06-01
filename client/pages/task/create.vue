<template>
  <div class="">
    <h1>定期タスク新規作成</h1>
    <v-card class="mx-auto px-12 py-12 my-12">
      <v-container>
        <v-row>
          <v-col cols="12" sm="6">
            <h4>タスク名</h4>
            <input-text v-model="form.taskName" />
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="6">
            <h4>実行アカウント</h4>
            <v-select
              v-model="form.selectedAccount"
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
              v-model="form.selectedAction"
              :items="actions"
              item-text="state"
              item-value="value"
            />
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="6">
            <h4>
              キーワード
              <v-tooltip top>
                <template #activator="{ on, attrs }">
                  <v-btn icon v-bind="attrs" v-on="on">
                    <v-icon>mdi-help-circle</v-icon>
                  </v-btn>
                </template>
                <span
                  >入力したキーワードで検索を行い、<br />結果に対して指定のアクションを行います。</span
                >
              </v-tooltip>
            </h4>
            <input-text v-model="form.keyword" />
            <v-radio-group
              v-if="keywordSplit.length > 1"
              v-model="option.keywordType"
            >
              <v-radio
                label="指定した単語のすべてが含まれる"
                value="and"
              ></v-radio>
              <v-radio
                label="指定した単語のいずれかが含まれる"
                value="or"
              ></v-radio>
            </v-radio-group>
          </v-col>
        </v-row>
        <expansion
          expansion-wrapper-class="expansion"
          expansion-header-class="expansion__header"
        >
          <template #expansion-header> 詳細設定を表示 </template>
          <template #expansion-content>
            <v-row>
              <v-col cols="12" sm="6">
                <h5>
                  除外キーワード
                  <v-tooltip top>
                    <template #activator="{ on, attrs }">
                      <v-btn icon v-bind="attrs" v-on="on">
                        <v-icon>mdi-help-circle</v-icon>
                      </v-btn>
                    </template>
                    <span
                      >複数のキーワードを除外する場合、<br />半角スペースで空けてください。</span
                    >
                  </v-tooltip>
                </h5>
                <input-text
                  v-model="option.excludeKey"
                  label="次の単語を除く"
                />
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="6">
                <h5>ハッシュタグ</h5>
                <input-text
                  v-model="option.containHashTag"
                  label="次のハッシュタグを含む"
                />
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="6" md="6">
                <h5>
                  アカウント
                  <v-tooltip top>
                    <template #activator="{ on, attrs }">
                      <v-btn icon v-bind="attrs" v-on="on">
                        <v-icon>mdi-help-circle</v-icon>
                      </v-btn>
                    </template>
                    <span
                      >複数のアカウントを指定する場合、<br />半角スペースで空けてください。</span
                    >
                  </v-tooltip>
                </h5>
                <div class="d-flex flex-column">
                  <input-text
                    v-model="option.fromAccount"
                    label="次のアカウントが送信"
                  />
                  <input-text
                    v-model="option.toAccount"
                    label="次のアカウント宛"
                  />
                  <input-text
                    v-model="option.mentionTo"
                    label="次のアカウントへの@ツイート"
                  />
                  <v-radio-group v-model="option.accountFilter">
                    <v-radio label="すべてのアカウント" value=""></v-radio>
                    <v-radio
                      label="フォローしているアカウント"
                      value="follows"
                    ></v-radio>
                  </v-radio-group>
                </div>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="6" md="6">
                <h5>エンゲージメント</h5>
                <div class="d-flex flex-column">
                  <input-text v-model="option.minReply" label="最小返信数" />
                  <input-text
                    v-model="option.minFavorite"
                    label="いいねの最小件数"
                  />
                  <input-text
                    v-model="option.minRetweet"
                    label="リツイートの最小件数"
                  />
                </div>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="6" md="4">
                <h5>日付</h5>
                <div class="d-flex row">
                  <date-input
                    v-model="option.startDate"
                    class="mr-4"
                    label="次の日付以降"
                  />
                  <date-input v-model="option.endDate" label="次の日付以前" />
                </div>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <h5>フィルター</h5>
                <div
                  v-for="filter in filterOptions"
                  :key="filter"
                  class="d-flex"
                >
                  <v-checkbox
                    v-model="option.filterSelected"
                    :value="filter"
                    :label="description[filter]"
                  />
                </div>
              </v-col>
            </v-row>
          </template>
        </expansion>
        <div class="submit mt-4">
          <v-btn
            class="submit__button"
            :disabled="!submittable"
            min-width="240px"
            color="primary"
            v-bind="size"
          >
            新規追加
          </v-btn>
        </div>
      </v-container>
    </v-card>
  </div>
</template>

<script lang="ts">
import {
  computed,
  defineComponent,
  reactive,
  Ref,
  useStore,
} from '@nuxtjs/composition-api'
import { TaskType } from '~/types/taskType'
import { StoreType } from '~/store/account'
import {
  filterDescription,
  FilterOption,
  filters,
} from '~/constant/twitterSearch'
import { useKeyword } from '~/composables/useKeyword'
import { useResponsiveButtonSize } from '~/composables/useResponsiveButtonSize'

interface Selectable {
  state: any
  value: any
}

interface Action {
  state: string
  value: TaskType | ''
}

interface Form {
  taskName: string
  selectedAction: TaskType | ''
  selectedAccount: string | object
  keyword: Ref<string>
}

export default defineComponent({
  components: {},
  layout: 'authenticated',
  middleware: 'fetchAccounts',
  setup() {
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
    const filterOptions: FilterOption = filters
    const description = filterDescription
    const { size } = useResponsiveButtonSize('md')

    const {
      keyword,
      keyOption: option,
      encodeOption,
      splitBlank,
    } = useKeyword()
    const form = reactive<Form>({
      taskName: '',
      selectedAction: '',
      selectedAccount: '',
      keyword,
    })
    const keywordSplit = computed(() => splitBlank(form.keyword))
    const submittable = computed(() => {
      return Object.values(form).every((value) => Boolean(value))
    })

    return {
      form,
      filterOptions,
      description,
      actions,
      accountList,
      option,
      encodeOption,
      keywordSplit,
      size,
      submittable,
    }
  },
})
</script>

<style lang="scss" scoped>
h4 {
  margin-bottom: 1rem;
}

h5 {
  margin-bottom: 0.5rem;
}

.expansion {
  &__header {
    width: 30%;
  }
}

.submit {
  display: flex;
  width: 100%;
  position: sticky;
  justify-content: center;
  bottom: 20px;
  z-index: 5;

  &__button {
    &:disabled {
      opacity: 1;
    }
  }
}
</style>
