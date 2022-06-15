import { NuxtApp } from '@nuxt/types/app'
import Vue from 'vue'

declare global {
  // eslint-disable-next-line no-var
  var $nuxt: NuxtApp
}
declare module '*.vue' {
  export default Vue
}
