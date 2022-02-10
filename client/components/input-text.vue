<template>
  <v-text-field
    :value="value"
    autofocus
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
import { defineComponent } from "@nuxtjs/composition-api";

export default defineComponent({
  name: 'InputText',
  props: {
    height: {
      type: Number,
      default: 48
    },
    value: [String, Number],
    placeholder: {
      type: String,
      required: false
    }
  },
})
</script>

<style scoped>

</style>
