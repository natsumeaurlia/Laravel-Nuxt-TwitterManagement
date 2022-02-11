<template>
  <v-app>
    <sidebar :items="[{icon: 'mdi-speedometer',name: 'ダッシュボード'},{icon: 'mdi-account',name: 'アカウント管理'}]"/>
    <v-main style="background-color:#F5F5F5;" class="fill-height">
      <v-container>
        <nuxt/>
      </v-container>
    </v-main>
  </v-app>
</template>

<script lang="ts">
import { defineComponent } from "@nuxtjs/composition-api";
import Sidebar from "~/components/dashboard/sidebar.vue";

export default defineComponent({
  components: { Sidebar }
})

</script>
