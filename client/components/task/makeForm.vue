<template>
  <v-container>
    <slot name="header"/>
    <v-row>
      <v-col cols="12" sm="6">
        <h4>タスク名</h4>
        <input-text :value="task.taskName" @input="task.taskName"/>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" sm="6">
        <h4>実行アカウント</h4>
        <v-select
          :value="task.selectedAccount" :items="accountList"
          item-text="state"
          item-value="value"
          @input="task.selectedAccount"
        />
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" sm="6">
        <h4>アクション</h4>
        <v-select
          :value="task.selectedAction" :items="actions"
          item-text="state"
          item-value="value"
          @input="task.selectedAction"
        />
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" sm="6">
        <h4>
          アクション実行件数
          <tooltip>
            1回の実行で、何件にアクションを行うか。<br/>例:アクションがいいね、件数10の場合。1回の実行で10件にいいねを行う。
          </tooltip>
        </h4>
        <div class="d-flex">
          <input-text
            :value="task.maxExecution" type="number"
            @input="task.maxExecution"/>
        </div>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" sm="6">
        <h4>
          スリープ設定
          <tooltip>
            1アクションごとにスリープを入れます。スリープを入れることによりBANの可能性を抑制します。
          </tooltip>
        </h4>
        <div class="d-flex">
          <input-text
            :value="task.minSleep" label="最小スリープ時間(秒)"
            type="number"
            @input="task.minSleep"
          />
          <input-text
            :value="task.maxSleep" label="最大スリープ時間(秒)"
            type="number"
            @input="task.maxSleep"
          />
        </div>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" sm="6">
        <h4>実行時間帯</h4>
        <div class="d-flex">
          <dialog-time-picker
            :value="task.startTimePeriod" label="開始時間帯"
            :max="task.endTimePeriod"
            @input="task.startTimePeriod"
          />
          <dialog-time-picker
            :value="task.endTimePeriod" label="終了時間帯"
            :min="task.startTimePeriod"
            @input="task.endTimePeriod"
          />
        </div>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" sm="6">
        <h4>
          キーワード
          <tooltip>
            入力したキーワードで検索を行い、<br/>結果に対して指定のアクションを行います。
          </tooltip>
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
              <tooltip>
                複数のキーワードを除外する場合、<br/>半角スペースで空けてください。
              </tooltip>
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
              <tooltip>
                複数のアカウントを指定する場合、<br/>半角スペースで空けてください。
              </tooltip>
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
              <input-text
                v-model="option.minReply"
                label="最小返信数"
                type="number"
              />
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
    <slot name="footer"/>
  </v-container>
</template>

<script lang="ts">
import { computed, defineComponent, PropType, useStore } from "@nuxtjs/composition-api";
import { TaskForm, Task } from "~/types/task";
import { StoreType } from "~/store/account";
import { filterDescription, FilterOption, filters } from "~/constant/twitterSearch";
import { useTask } from "~/composables/useTask";
import { actions } from "~/constant/actions";

interface Selectable {
  state: any
  value: any
}

export default defineComponent({
  name: "Form",
  props: {
    task: {
      required: false,
      type: Object as PropType<TaskForm | Task>,
      default: null
    }
  },
  setup(props) {
    const store = useStore<StoreType>()
    const accountList = computed(() =>
      store.state.account.accounts.map((account) => {
        return { state: account.name, value: account.id } as Selectable
      })
    )
    const filterOptions: FilterOption = filters
    const description = filterDescription

    const { inputKeyword, splitBlank, keyOption: option } = useTask()
    const k = props.task.keyword as string;
    inputKeyword.value = k;
    const keywordSplit = computed(() => splitBlank(k))

    return {
      inputKeyword,
      filterOptions,
      description,
      actions,
      accountList,
      option,
      keywordSplit,
    }
  }
})
</script>

<style scoped>

</style>
