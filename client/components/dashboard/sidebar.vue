<template>
  <v-navigation-drawer app class="grey darken-4 text--white">
    <v-container>
      <v-list nav>
        <v-list-item v-for="nav in items" :key="nav.name">
          <NuxtLink v-if="nav.to" :to="nav.to" class="d-inline-flex text-decoration-none">
            <v-list-item-avatar v-if="nav.icon" class="white--text">
              <v-icon class="white--text">{{ nav.icon }}</v-icon>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title class="white--text">{{ nav.name }}</v-list-item-title>
            </v-list-item-content>
          </NuxtLink>
          <template v-else>
            <v-list-item-avatar v-if="nav.icon">
              <v-icon class="white--text">{{ nav.icon }}</v-icon>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title class="white--text">{{ nav.name }}
              </v-list-item-title>
            </v-list-item-content>
          </template>
        </v-list-item>
      </v-list>
    </v-container>
  </v-navigation-drawer>
</template>

<script lang="ts">
import { defineComponent, PropType } from '@nuxtjs/composition-api'
import { NavItems } from '~/types/sidebarItem'

export default defineComponent({
  name: 'Sidebar',
  props: {
    items: {
      type: Array as PropType<NavItems>,
    },
  },
})
</script>

<style lang="scss">
.nuxt-link-active{
  border-bottom: 1px solid gray;
}
</style>
