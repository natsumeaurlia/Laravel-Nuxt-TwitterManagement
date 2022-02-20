<template>
  <v-text-field
    :value="email"
    dense
    :height="height"
    outlined
    :placeholder="placeholder"
    @input="$emit('input', $event)"
  >
    <template #label>
      <slot name="label"></slot>
    </template>
  </v-text-field>
</template>

<script lang="ts">
import { defineComponent } from '@nuxtjs/composition-api'

export default defineComponent({
  name: 'InputEmail',
  props: {
    height: {
      type: Number,
      default: 48,
    },
    email: {
      type: String,
    },
    placeholder: {
      type: String,
      required: false,
    },
  },
  data() {
    return {
      // emailRules: {
      //   required: (value: string | boolean) =>
      //     !!value || 'メールアドレスは必須です',
      //   regex: (value: any) =>
      //     /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(
      //       value
      //     ) || 'メールアドレスの形式が違います'
      // }
    }
  },
})
</script>

<style scoped></style>
