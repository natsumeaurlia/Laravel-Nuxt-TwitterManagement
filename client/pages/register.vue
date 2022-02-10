<template>
  <v-card
    class="mx-auto fill-width"
    flat
    max-width="640"
  >
    <v-card-title class="text-center pa-8">
      <h4 class="fill-width">新規登録</h4>
    </v-card-title>
    <v-divider></v-divider>
    <div class="px-6 py-8">
      <div style="max-width:344px" class="mx-auto">
        <div class="pt-6">
          <div>
            <input-text v-model="name">
              <template #label>ユーザー名</template>
            </input-text>
            <input-email v-model="email">
              <template #label>メールアドレス</template>
            </input-email>
            <input-password v-model="password">
              <template #label>パスワード</template>
            </input-password>
            <input-password v-model="passwordConfirmation">
              <template #label>パスワード再確認</template>
            </input-password>
          </div>
          <div class="pb-8">
            <v-btn
              class="fill-width caption"
              color="#FFCB00"
              depressed
              height="48px"
              tile
              @click="register"
            >
              新規登録
            </v-btn>
          </div>
          <v-divider></v-divider>
          <div class="pt-8 pb-4">
            <span>すでにアカウントをお持ちですか？</span>
            <nuxt-link to="/login">ログインに移動</nuxt-link>
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
import InputText from "~/components/input-text.vue";

export default defineComponent({
  components: { InputText, InputPassword, InputEmail },
  setup() {
    // data
    const name = ref<string>("");
    const email = ref<string>("");
    const password = ref<string>("");
    const passwordConfirmation = ref<string>("");

    return {
      name,
      email,
      password,
      passwordConfirmation
    }
  },
  methods: {
    async register() {
      try {
        this.$nuxt.$loading.start();

        await this.$userRepository.store(this.name, this.email, this.password);
        await this.$auth.loginWith('sanctum', { data: { email: this.email, password: this.password } })
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
