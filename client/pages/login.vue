<template>
  <v-card
      class="mx-auto fill-width"
      flat
      max-width="640"
  >
    <v-card-title class="text-center pa-8">
      <h4 class="fill-width">ログイン</h4>
    </v-card-title>
    <v-divider></v-divider>
    <div class="px-6 py-8">
      <div style="max-width:344px" class="mx-auto">
        <div class="pt-6">
          <div>
            <input-email />
            <input-password />
          </div>
          <div class="login-btn pb-8">
            <v-btn
                class="fill-width caption"
                color="#FFCB00"
                depressed
                height="48px"
                tile
            >
              ログイン
            </v-btn>
          </div>
          <v-divider></v-divider>
          <div class="pt-8 pb-4">
            <span>まだアカウントをお持ちではないですか？</span>
            <nuxt-link to="/login">新規登録に移動</nuxt-link>
          </div>
        </div>
      </div>
    </div>
  </v-card>
</template>

<script lang="ts">

definePageMeta({
  layout: 'auth'
})

</script>

<style scoped>

</style>