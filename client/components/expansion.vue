<template>
  <div :class="expansionWrapperClass">
    <v-expansion-panels flat :class="expansionHeaderClass">
      <v-expansion-panel>
        <v-expansion-panel-header :class="expansionHeaderButtonClass" @click="expand = !expand">
          <slot name="expansion-header" />
        </v-expansion-panel-header>
      </v-expansion-panel>
    </v-expansion-panels>
    <transition name="expansion">
      <div v-if="expand">
        <slot name="expansion-content"/>
      </div>
    </transition>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@nuxtjs/composition-api";

export default defineComponent({
  name: 'Expansion',
  props: {
    expansionWrapperClass: {
      type: [String, Array, Object],
      default: null,
    },
    expansionHeaderClass: {
      type: [String, Array, Object],
      default: null,
    },
    expansionHeaderButtonClass: {
      type: [String, Array, Object],
      default: null,
    },
  },
  setup() {
    const expand = false;
    return { expand }
  }
})
</script>

<style scoped lang="scss">
.v-expansion-panel-header {
  padding: 0;
}

.expansion-enter-active,
.expansion-leave-active {
  transition: max-height 0.3s ease-in;
}

.expansion-enter-to, .expansion-leave {
  max-height: 100px;
  overflow: hidden;
}

.expansion-enter, .expansion-leave-to {
  overflow: hidden;
  max-height: 0;
}

</style>
