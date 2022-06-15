<template>
  <div class="">
    <h1>定期タスク新規作成</h1>
    <v-card class="mx-auto px-12 py-12 my-12">
      <v-container>
        <v-row>
          <v-col cols="12" sm="6">
            <h4>タスク名</h4>
            <input-text v-model="task.taskName"/>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="6">
            <h4>実行アカウント</h4>
            <v-select
              v-model="task.selectedAccount"
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
              v-model="task.selectedAction"
              :items="actions"
              item-text="state"
              item-value="value"
            />
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="6">
            <h4>
              アクション実行件数
              <tooltip>1回の実行で、何件にアクションを行うか。<br>例:アクションがいいね、件数10の場合。1回の実行で10件にいいねを行う。</tooltip>
            </h4>
            <div class="d-flex">
              <input-text v-model="task.maxExecution" type="number" />
            </div>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="6">
            <h4>
              スリープ設定
              <tooltip>1アクションごとにスリープを入れます。スリープを入れることによりBANの可能性を抑制します。</tooltip>
            </h4>
            <div class="d-flex">
              <input-text v-model="task.minSleep" label="最小スリープ時間(秒)" type="number" />
              <input-text v-model="task.maxSleep" label="最大スリープ時間(秒)" type="number" />
            </div>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="6">
            <h4>実行時間帯</h4>
            <div class="d-flex">
              <dialog-time-picker v-model="task.startTimePeriod" label="開始時間帯" :max="task.endTimePeriod" />
              <dialog-time-picker v-model="task.endTimePeriod" label="終了時間帯" :min="task.startTimePeriod" />
            </div>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="6">
            <h4>
              キーワード
              <tooltip>入力したキーワードで検索を行い、<br/>結果に対して指定のアクションを行います。</tooltip>
            </h4>
            <input-text v-model="inputKeyword"/>
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
          <template #expansion-header> 詳細設定を表示</template>
          <template #expansion-content>
            <v-row>
              <v-col cols="12" sm="6">
                <h5>
                  除外キーワード
                  <tooltip>複数のキーワードを除外する場合、<br/>半角スペースで空けてください。</tooltip>
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
                    <tooltip>複数のアカウントを指定する場合、<br/>半角スペースで空けてください。</tooltip>
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
                  <input-text v-model="option.minReply" label="最小返信数" type="number"/>
                  <input-text
                    v-model="option.minFavorite"
                    label="いいねの最小件数"
                    type="number"
                  />
                  <input-text
                    v-model="option.minRetweet"
                    label="リツイートの最小件数"
                    type="number"
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
                  <date-input v-model="option.endDate" label="次の日付以前"/>
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
            @click="onSubmit"
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
  defineComponent, useContext, useRouter,
  useStore,
} from '@nuxtjs/composition-api'
import { TaskType } from '~/types/taskType'
import { StoreType } from '~/store/account'
import {
  filterDescription,
  FilterOption,
  filters,
} from '~/constant/twitterSearch'
import { useResponsiveButtonSize } from '~/composables/useResponsiveButtonSize'
import { useTask } from "~/composables/useTask";

interface Selectable {
  state: any
  value: any
}

interface Action {
  state: string
  value: TaskType | ''
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

    const { task, submittable, inputKeyword, keyOption: option, splitBlank } = useTask();
    const keywordSplit = computed(() => splitBlank(inputKeyword.value));

    const $router = useRouter();
    const { $taskRepository } = useContext();

    const onSubmit = async () => {
      // 保存
      try {
        $nuxt.$loading.start()
        await $taskRepository.store(task)
        $nuxt.$loading.finish()
        $router.push('/task')
      } catch (e) {
        $nuxt.$loading.finish()
        // 失敗時の処理
      }
    }

    return {
      task,
      inputKeyword,
      filterOptions,
      description,
      actions,
      accountList,
      option,
      keywordSplit,
      size,
      submittable,
      onSubmit
    }
  }
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
