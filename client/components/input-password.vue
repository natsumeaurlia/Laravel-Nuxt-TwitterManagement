<template>
  <v-text-field
    :value="password"
    @input="$emit('input', $event)"
    :append-inner-icon="passwordShow ? 'mdi-eye' : 'mdi-eye-off'"
    :type="passwordShow ? 'text' : 'password'"
    dense
    :height="height"
    name="input-password"
    outlined
    placeholder="パスワード"
    @click:append-inner="passwordShow = !passwordShow"
  />
</template>

<script lang="ts">
import { defineComponent } from '@nuxtjs/composition-api'
export default defineComponent({
  name: "InputPassword",
  props: {
    height: {
      type: Number,
      default: 48
    },
    password: {
      type: String
    }
  },
  data() {
    return {
      passwordShow: false,
      passwordRules: {
        required: (value: string | boolean) =>
          !!value || 'パスワードは必須です',
        regex: (value: any) =>
          /^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,128}$/.test(value) ||
          '半角英小文字大文字数字をそれぞれ1種類以上含む7文字以上で入力してください'
      }
    }
  }
})
</script>

<style scoped>

</style>
