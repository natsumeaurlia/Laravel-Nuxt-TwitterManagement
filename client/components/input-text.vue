<template>
  <v-text-field
    :value="value"
    dense
    :height="height"
    outlined
    :placeholder="placeholder"
    :label="label"
    :type="type"
    @input="$emit('input', $event)"
  >
    <template #label>
      <slot name="label"></slot>
    </template>
  </v-text-field>
</template>

<script lang="ts">
import { defineComponent, PropType } from '@nuxtjs/composition-api'
import { HTMLInputTypeAttribute } from '~/types/input'

export default defineComponent({
  name: 'InputText',
  props: {
    height: {
      type: Number,
      default: 48,
    },
    value: [String, Number],
    placeholder: {
      type: String,
      required: false,
    },
    label: {
      type: String,
      required: false,
    },
    type: {
      type: String as PropType<HTMLInputTypeAttribute>,
      default: 'text',
    },
  },
})
</script>

<style scoped></style>
