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
            <input-email v-model="email"/>
            <input-password v-model="password"/>
          </div>
          <div class="pb-8">
            <v-btn
              class="fill-width caption"
              color="#FFCB00"
              depressed
              height="48px"
              tile
              @click="login"
            >
              ログイン
            </v-btn>
          </div>
          <v-divider></v-divider>
          <div class="pt-8 pb-4">
            <span>まだアカウントをお持ちではないですか？</span>
            <nuxt-link to="/register">新規登録に移動</nuxt-link>
          </div>
        </div>
      </div>
    </div>
  </v-card>
</template>

<script lang="ts">
import { defineComponent, ref } from '@nuxtjs/composition-api'
import InputEmail from "~/components/input-email.vue";
import InputPassword from "~/components/input-password.vue";

export default defineComponent({
  components: { InputPassword, InputEmail },
  middleware: 'guest',
  setup() {
    const email = ref<String>('');
    const password = ref<String>('');

    return { email, password, }
  },
  methods: {
    async login() {
      try {
        this.$nuxt.$loading.start();
        await this.$auth.loginWith('sanctum', {
          data: { email: this.email, password: this.password }
        });
        this.$nuxt.$loading.finish();
        await this.$router.push('/dashboard');
      } catch (err) {
        this.$nuxt.$loading.finish();
      }
    }
  }
})

</script>

<style scoped>

</style>
