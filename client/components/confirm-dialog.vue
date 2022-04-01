<template>
  <v-dialog :value="show" :max-width="maxWidth || '600px'" @input="$emit('close', $event)">
    <v-card>
      <v-card-title class="text-h5">
        <slot name="title"></slot>
      </v-card-title>
      <v-card-actions>
        <v-spacer></v-spacer>
        <slot name="actions"></slot>
        <v-spacer></v-spacer>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script lang="ts">
import { defineComponent } from "@nuxtjs/composition-api";

export default defineComponent({
  name: "ConfirmDialog",
  props: {
    show: {
      type: Boolean,
      default: false,
    },
    maxWidth: {
      type: Number,
      default: null,
    }
  },
})
</script>

<style scoped>

</style>
