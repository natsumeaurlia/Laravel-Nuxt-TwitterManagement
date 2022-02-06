<template>
  <v-text-field
    v-model="password"
    :append-inner-icon="passwordShow ? 'mdi-eye' : 'mdi-eye-off'"
    :rules="[passwordRules.required, passwordRules.regex]"
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
export default {
  name: "InputPassword",
  props: {
    height: {
      type: Number,
      default: 48
    }
  },
  data() {
    return {
      password: null,
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
}
</script>

<style scoped>

</style>
