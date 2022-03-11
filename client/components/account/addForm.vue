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
                v-model="token"
                label="Access Token*"
                required
              />
            </v-col>
            <v-col cols="12">
              <v-text-field
                v-model="tokenSecret"
                label="Secret Access Token*"
                required
              />
            </v-col>
            <v-col cols="12">
              <v-text-field
                v-model="consumerKey"
                label="Consumer Key*"
                required
              />
            </v-col>
            <v-col cols="12">
              <v-text-field
                v-model="consumerSecret"
                label="Secret Consumer Key*"
                required
              />
            </v-col>
          </v-row>
        </v-container>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color='primary'
            :disabled="!canSubmit"
            text
            @click="$emit('submit', $event)"
          >
            新規作成
          </v-btn>
          <v-btn
            color="red darken-1"
            text
            @click="$emit('close', $event)"
          >
            閉じる
          </v-btn>
        </v-card-actions>
      </v-card-text>
    </v-card>
  </v-dialog>

</template>

<script lang="ts">
import { defineComponent, PropType } from '@nuxtjs/composition-api'
import { TokenForm, usePropAccountForm } from "~/composables/useAccountForm";

export default defineComponent({
  props: {
    show: {
      type: Boolean,
      default: false,
    },
    value: {
      type: Object as PropType<TokenForm>,
      required: true
    },
    canSubmit: {
      type: Boolean,
      default: false
    }
  },
  setup(props, { emit }) {
    const { token, tokenSecret, consumerKey, consumerSecret } = usePropAccountForm(props, emit);
    return { token, tokenSecret, consumerKey, consumerSecret }
  }
})
</script>

<style scoped></style>
