<template>
  <div>
    <v-app-bar v-show="showAppBar" color="grey darken-4" dark>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
    </v-app-bar>

    <v-navigation-drawer v-model="drawer" app class="grey darken-4 text--white">
      <v-container>
        <v-list nav>
          <v-list-item v-for="nav in items" :key="nav.name">
            <NuxtLink
              v-if="nav.to"
              :to="nav.to"
              class="d-inline-flex text-decoration-none"
            >
              <v-list-item-avatar v-if="nav.icon" class="white--text">
                <v-icon class="white--text">{{ nav.icon }}</v-icon>
              </v-list-item-avatar>
              <v-list-item-content>
                <v-list-item-title class="white--text">{{
                  nav.name
                }}</v-list-item-title>
              </v-list-item-content>
            </NuxtLink>
            <template v-else>
              <v-list-item-avatar v-if="nav.icon">
                <v-icon class="white--text">{{ nav.icon }}</v-icon>
              </v-list-item-avatar>
              <v-list-item-content>
                <v-list-item-title class="white--text">
                  {{ nav.name }}
                </v-list-item-title>
              </v-list-item-content>
            </template>
          </v-list-item>
        </v-list>
      </v-container>
    </v-navigation-drawer>
  </div>
</template>

<script lang="ts">
import {
  computed,
  defineComponent,
  PropType,
  ref,
  useContext,
} from '@nuxtjs/composition-api'
import { NavItems } from '~/types/sidebarItem'

export default defineComponent({
  name: 'Sidebar',
  props: {
    items: {
      type: Array as PropType<NavItems>,
    },
  },
  setup() {
    // smサイズ以下の場合drawerを表示する
    const lessThanSm = () => {
      const { $vuetify } = useContext()
      return $vuetify.breakpoint.sm || $vuetify.breakpoint.xs
    }
    const drawer = ref<Boolean>(!lessThanSm())
    const showAppBar = computed(() => {
      return lessThanSm()
    })
    return { drawer, showAppBar }
  },
})
</script>

<style lang="scss">
.nuxt-link-active {
  border-bottom: 1px solid gray;
}
</style>
