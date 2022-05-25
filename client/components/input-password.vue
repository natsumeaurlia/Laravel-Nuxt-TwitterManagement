<template>
  <v-text-field
    :value="password"
    :append-icon="passwordShow ? 'mdi-eye' : 'mdi-eye-off'"
    :type="passwordShow ? 'text' : 'password'"
    dense
    :height="height"
    name="input-password"
    outlined
    :placeholder="placeholder"
    @input="$emit('input', $event)"
    @click:append="passwordShow = !passwordShow"
  >
    <template #label>
      <slot name="label"></slot>
    </template>
  </v-text-field>
</template>

<script lang="ts">
import { defineComponent } from '@nuxtjs/composition-api'

export default defineComponent({
  name: 'InputPassword',
  props: {
    height: {
      type: Number,
      default: 48,
    },
    password: {
      type: String,
    },
    placeholder: {
      type: String,
      required: false,
    },
  },
  setup() {
    return {
      passwordShow: false,
      passwordRules: {
        required: (value: string | boolean) =>
          !!value || 'パスワードは必須です',
        regex: (value: any) =>
          /^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,128}$/.test(value) ||
          '半角英小文字大文字数字をそれぞれ1種類以上含む7文字以上で入力してください',
      },
    }
  },
})
</script>

<style scoped></style>
