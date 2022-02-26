<template>
  <v-dialog
    :value="show"
    max-width="600px"
    @input="$emit('close', $event)"
  >
    <v-card>
      <v-card-title>
        <span class="text-h5">アカウント追加</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row>
            <v-col cols="12">
              <v-text-field
                label="Access Token*"
                required
              />
            </v-col>
            <v-col cols="12">
              <v-text-field
                label="Secret Access Token*"
                required
              />
            </v-col>
            <v-col cols="12">
              <v-text-field
                label="Consumer Key*"
                required
              />
            </v-col>
            <v-col cols="12">
              <v-text-field
                label="Secret Consumer Key*"
                required
              />
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
    </v-card>
  </v-dialog>

</template>

<script lang="ts">
import { defineComponent } from '@nuxtjs/composition-api'

export default defineComponent({
  props: {
    show: {
      type: Boolean,
      default: false,
    },
  }
})
</script>

<style scoped></style>
