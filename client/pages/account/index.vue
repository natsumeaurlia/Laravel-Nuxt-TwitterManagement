<template>
  <div class="">
    <h1>アカウント管理</h1>
    <add-form :show="createDialog" @close="createDialog = false"/>

    <div class="mt-8"/>
    <v-data-table
      :items="accounts"
      class="elevation-1"
      :headers="headers"
    >
      <template #top>
        <v-toolbar
          flat
        >
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            dark
            class="mb-2"
            @click="createDialog = true"
          >
            新規追加
          </v-btn>
        </v-toolbar>
      </template>
      <template #no-data>
        アカウントがありません。
      </template>
    </v-data-table>
  </div>
</template>

<script lang="ts">
import { computed, defineComponent, ref, useFetch, useStore } from '@nuxtjs/composition-api'
import addForm from '~/components/account/addForm.vue'
import { StoreType } from "~/store/account";

export default defineComponent({
  components: {
    addForm
  },
  layout: 'authenticated',
  setup() {
    const createDialog = ref<Boolean>(false)
    const headers = [
      { text: 'name', value: 'name' },
      { text: 'screen name', value: 'screen_name' },
    ];

    const store = useStore<StoreType>();
    useFetch(() => {
      if (store.state.account.accounts.length === 0) {
        store.dispatch('account/fetchAccounts')
      }
    })

    const accounts = computed(() => store.state.account.accounts)

    return { createDialog, accounts, headers }
  }
})
</script>

<style scoped></style>
