<template>
  <div class="">
    <h1>アカウント管理</h1>
    <add-form
      v-model="form"
      :can-submit="canSubmit"
      :show="createDialog"
      @submit="onSubmit"
      @close="createDialog = false"
    />

    <div class="mt-8" />
    <v-data-table
      item-key="name"
      :items="accounts"
      class="elevation-1"
      :headers="headers"
    >
      <template #top>
        <v-toolbar flat>
          <v-spacer></v-spacer>
          <v-btn color="primary" dark class="mb-2" @click="createDialog = true">
            新規追加
          </v-btn>
        </v-toolbar>
      </template>
      <template #no-data> アカウントがありません。</template>
      <template #item.delete="{ item }">
        <v-icon small @click="deleteDialog = true"> mdi-delete </v-icon>
        <confirm-dialog :show="deleteDialog" @close="deleteDialog = false">
          <template #title>アカウントを削除してよろしいですか？</template>
          <template #actions>
            <v-btn color="blue darken-1" text @click="deleteDialog = false"
              >Cancel</v-btn
            >
            <v-btn color="red darken-1" text @click="onDelete(item.id)"
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
  computed,
  defineComponent,
  ref,
  useStore,
} from '@nuxtjs/composition-api'
import addForm from '~/components/account/addForm.vue'
import { StoreType as AccountStore } from '~/store/account'
import { useAccountForm } from '~/composables/useAccountForm'

export default defineComponent({
  components: {
    addForm,
  },
  layout: 'authenticated',
  middleware: 'fetchAccounts',
  setup() {
    const createDialog = ref<Boolean>(false)
    const deleteDialog = ref<Boolean>(false)

    const headers = [
      { text: 'name', value: 'name' },
      { text: 'screen name', value: 'screen_name' },
      { text: '削除', value: 'delete' },
    ]

    const store = useStore<AccountStore>()

    const accounts = computed(() => store.state.account.accounts)

    const { form, canSubmit, initializeForm } = useAccountForm()

    const onSubmit = () => {
      if (!canSubmit) {
        return
      }
      store.dispatch('account/createAccounts', { ...form })
      createDialog.value = false
      initializeForm()
    }

    const onDelete = (id: string) => {
      store.dispatch('account/deleteAccount', id)
      deleteDialog.value = false
    }

    return {
      createDialog,
      deleteDialog,
      accounts,
      headers,
      canSubmit,
      form,
      onSubmit,
      onDelete,
    }
  },
})
</script>

<style scoped></style>
