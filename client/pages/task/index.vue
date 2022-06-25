<template>
  <div class="">
    <h1>定期タスク管理</h1>
    <v-data-table
      item-key="id"
      :items="tasks"
      class="elevation-1 mt-8"
      :headers="headers"
    >
      <template #top>
        <v-toolbar flat>
          <v-spacer></v-spacer>
          <v-btn color="primary" dark to="/task/create" nuxt class="mb-2">
            新規追加
          </v-btn>
        </v-toolbar>
      </template>
      <template #no-data>タスクがありません。</template>
      <template #item.is_enable="{ item }">
        <v-switch v-model="item.is_enable" />
      </template>
      <template #item.edit="{ item }">
        <v-icon small @click="$nuxt.$router.push(`/task/${item.id}`)">
          mdi-pencil
        </v-icon>
      </template>
      <template #item.delete="{ item }">
        <v-icon small @click="deleteDialog = true"> mdi-delete </v-icon>
        <confirm-dialog :show="deleteDialog" @close="deleteDialog = false">
          <template #title>タスクを削除してよろしいですか？</template>
          <template #actions>
            <v-btn color="blue darken-1" text @click="deleteDialog = false"
              >Cancel</v-btn
            >
            <v-btn color="red darken-1" text @click="deleteTask(item)"
              >OK</v-btn
            >
          </template>
        </confirm-dialog>
      </template>
    </v-data-table>
  </div>
</template>

<script lang="ts">
import {
  defineComponent,
  ref,
  useContext,
  useFetch,
} from '@nuxtjs/composition-api'
import { Task } from '~/types/task'

export default defineComponent({
  components: {},
  layout: 'authenticated',
  setup() {
    const tasks = ref<Task[] | []>([])
    const deleteDialog = ref<Boolean>(false)
    const { $taskRepository } = useContext()
    const { fetch } = useFetch(async () => {
      const { data } = await $taskRepository.fetchAll()
      tasks.value = data
    })
    const headers = [
      { text: 'タスク名', value: 'name' },
      { text: 'アカウント', value: 'account.screen_name' },
      { text: 'アクション種別', value: 'type' },
      { text: '有効/無効', value: 'is_enable' },
      { text: '編集', value: 'edit' },
      { text: '削除', value: 'delete' },
    ]
    // const toggleEnable = (task: Task) => {
    //   // updateで有効無効切り替える
    // }
    const deleteTask = (task: Task) => {
      try {
        $taskRepository.destroy(task.id)
        fetch()
      } catch (e) {}
      deleteDialog.value = false
    }
    // Access fetch error, pending and timestamp
    return { tasks, headers, deleteDialog, deleteTask }
  },
})
</script>

<style scoped></style>
