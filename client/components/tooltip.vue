<template>
  <v-tooltip top :open-on-hover="true" :open-on-click="false">
    <template #activator="{ on, attrs }">
      <v-btn icon v-bind="attrs" v-on="on">
        <v-icon>mdi-help-circle</v-icon>
      </v-btn>
    </template>
    <slot />
  </v-tooltip>
</template>

<script lang="ts">
import { defineComponent } from '@nuxtjs/composition-api'

export default defineComponent({
  name: 'Tooltip',
})
</script>

<style scoped></style>
