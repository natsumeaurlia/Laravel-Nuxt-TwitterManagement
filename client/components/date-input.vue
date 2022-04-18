<template>
  <div>
    <v-menu
      min-width="auto"
      offset-y
      bottom
    >
      <template #activator="{ on, attrs }">
        <v-text-field
          :value="value"
          :prepend-icon="icon"
          append-icon="mdi-close"
          :label="label"
          readonly
          v-bind="attrs"
          @click:append="clearDate"
          v-on="on"
        />
      </template>
      <v-date-picker locale="ja" @input="$emit('input', $event)"/>
    </v-menu>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@nuxtjs/composition-api";

export default defineComponent({
  name: 'DateInput',
  props: {
    value: [String, Number],
    icon: {
      type: String,
      default: 'mdi-calendar'
    },
    label: {
      type: String,
      default: ''
    }
  },
  setup(_, context) {
    const clearDate = () => {
      context.emit('input', '')
    }
    return { clearDate }
  }
})
</script>

<style scoped>

</style>
