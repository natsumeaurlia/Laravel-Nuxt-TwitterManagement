<template>
  <v-app>
    <sidebar :items="items"/>
    <v-main style="background-color: #f5f5f5" class="fill-height">
      <v-container class="grey--text text--darken-3">
        <nuxt/>
      </v-container>
    </v-main>
  </v-app>
</template>

<script lang="ts">
import { defineComponent } from '@nuxtjs/composition-api'
import Sidebar from '~/components/dashboard/sidebar.vue'
import { useNav } from "~/composables/useNav";

export default defineComponent({
  components: { Sidebar },
  middleware: 'auth',
  setup() {
    const { items } = useNav();
    return { items }
  }
})
</script>
