<template>
  <v-dialog
    ref="dialog"
    v-model="modal"
    width="290px"
  >
    <template #activator="{ on, attrs }">
      <v-text-field
        :label="label"
        prepend-icon="mdi-clock-time-four-outline"
        readonly
        v-bind="attrs"
        :value="value"
        :style="{width: computedWidth}"
        @input="$emit('input', $event)"
        v-on="on"
      ></v-text-field>
    </template>
    <v-time-picker
      v-if="modal"
      full-width
      :value="value"
      :max="max"
      :min="min"
      @input="$emit('input', $event)"
    >
      <v-spacer></v-spacer>
      <v-btn
        text
        color="primary"
        @click="modal = false"
      >
        Cancel
      </v-btn>
      <v-btn
        text
        color="primary"
        @click="$refs.dialog.save(value)"
      >
        OK
      </v-btn>
    </v-time-picker>
  </v-dialog>
</template>

<script lang="ts">
import { computed, defineComponent, PropType } from "@nuxtjs/composition-api";
import { Hi } from "~/types/time";

export default defineComponent({
  name: "DialogTimePicker",
  props: {
    value: String as PropType<Hi>,
    label: String,
    width: {
      type: [Number, String],
      default: '200px',
    },
    min: {
      type: String as PropType<Hi>,
      required: false
    },
    max: {
      type: String as PropType<Hi>,
      required: false
    }
  },
  setup(props) {
    const computedWidth = computed(() => {
      return Number.isInteger(props.width) ? `${props.width}px` : props.width
    })
    return {
      modal: false,
      computedWidth
    }
  }
})
</script>

<style scoped>

</style>
