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
            <input-email v-model="form.email" />
            <input-password v-model="form.password"/>
          </div>
          <div class="pb-8">
            <v-btn
                @click="login"
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
import InputEmail from "~/components/input-email.vue";
import InputPassword from "~/components/input-password.vue";
import { defineComponent } from '@vue/composition-api'
export default defineComponent({
  components: { InputPassword , InputEmail },
  data() {
    return {
      form: {
        email: '',
        password: ''
      }
    }
  },
  methods: {
    async login() {
      try {
        const response = await this.$auth.loginWith('sanctum', {
          data: this.form
        })
        console.log(response)
      } catch (err) {

      }
    }
  }
})

</script>

<style scoped>

</style>
