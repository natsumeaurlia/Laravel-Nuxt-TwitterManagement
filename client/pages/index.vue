<template>
  <div>
    <navigation :color="color" :flat="flat" />
    <v-main class="pt-0">
      <home />
      <about />
      <download />
      <pricing />
      <contact />
    </v-main>
    <v-scale-transition>
      <v-btn
        v-show="fab"
        v-scroll="onScroll"
        fab
        dark
        fixed
        bottom
        right
        color="secondary"
        @click="toTop"
      >
        <v-icon>mdi-arrow-up</v-icon>
      </v-btn>
    </v-scale-transition>
    <foot />
  </div>
</template>

<script lang="ts">
import {
  defineComponent,
  onMounted,
  ref,
  useContext,
  watch,
} from '@nuxtjs/composition-api'
import navigation from '~/components/top/navigation.vue'
import foot from '~/components/top/footer.vue'
import home from '~/components/top/home.vue'
import about from '~/components/top/about.vue'
import download from '~/components/top/download.vue'
import pricing from '~/components/top/pricing.vue'
import contact from '~/components/top/contact.vue'

export default defineComponent({
  components: {
    navigation,
    foot,
    home,
    about,
    download,
    pricing,
    contact,
  },
  layout: 'app',
  setup() {
    const fab = ref(false)
    const color = ref('')
    const flat = ref(false)

    onMounted(() => {
      const top = window.scrollY || 0
      if (top <= 60) {
        color.value = 'transparent'
        flat.value = true
      }
    })

    watch(fab, (newVal) => {
      if (newVal) {
        color.value = 'secondary'
        flat.value = false
      } else {
        color.value = 'transparent'
        flat.value = true
      }
    })

    const onScroll = (e) => {
      if (typeof window === 'undefined') return
      const top = window.scrollY || e.target.scrollTop || 0
      fab.value = top > 60
    }

    const { $vuetify } = useContext()
    const toTop = () => {
      $vuetify.goTo(0)
    }

    return { fab, color, flat, onScroll, toTop }
  },
})
</script>
