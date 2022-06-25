<template>
  <div class="">
    <h1>定期タスク新規作成</h1>
    <v-card class="mx-auto px-12 py-12 my-12">
      <task-make-form :task="task">
        <template #footer>
          <div class="submit mt-4">
            <v-btn
              :disabled="!submittable"
              class="submit__button"
              color="primary"
              min-width="240px"
              v-bind="size"
              @click="onSubmit"
            >
              新規追加
            </v-btn>
          </div>
        </template>
      </task-make-form>
    </v-card>
  </div>
</template>

<script lang="ts">
import { defineComponent, useContext, useRouter } from '@nuxtjs/composition-api'
import { useTask } from '~/composables/useTask'

export default defineComponent({
  components: {},
  layout: 'authenticated',
  middleware: 'fetchAccounts',
  setup() {
    const { makeTask, canSubmit } = useTask()
    const task = makeTask()
    const submittable = canSubmit(task)

    const $router = useRouter()
    const { $taskRepository } = useContext()

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
      size,
      submittable,
      onSubmit,
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
