<template>
  <v-text-field
    v-model="email"
    :rules="[emailRules.required, emailRules.regex]"
    autofocus
    dense
    :height="height"
    outlined
    placeholder="メールアドレス"
  />
</template>

<script lang="ts">
export default {
  name: "InputEmail",
  props: {
    height: {
      type: Number,
      default: 48
    }
  },
  data() {
    return {
      email: null,
      emailRules: {
        required: (value: string | boolean) =>
          !!value || 'メールアドレスは必須です',
        regex: (value: any) =>
          /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(
            value
          ) || 'メールアドレスの形式が違います'
      }
    }
  }

}
</script>

<style scoped>

</style>
