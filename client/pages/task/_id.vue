<template>
  <div class="">
    <h1>定期タスク新規作成</h1>
    <v-card class="mx-auto px-12 py-12 my-12">
      <task-make-form v-if="task" :task="task" />
    </v-card>
  </div>
</template>

<script lang="ts">
import {
  defineComponent,
  ref,
  useContext,
  useFetch,
} from '@nuxtjs/composition-api'
import { useTask } from '~/composables/useTask'

export default defineComponent({
  components: {},
  layout: 'authenticated',
  middleware: 'fetchAccounts',
  setup() {
    const { params } = useContext()
    const { makeTask } = useTask()
    const task = ref()
    const { $taskRepository } = useContext()

    useFetch(async () => {
      const { data } = await $taskRepository.fetch(params.value.id)
      if (data) {
        task.value = makeTask(data)
      }
    })
    return { task }
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
