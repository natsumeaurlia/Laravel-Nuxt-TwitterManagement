import { createVuetify } from "vuetify";
import * as Components from 'vuetify/components'
import '@mdi/font/css/materialdesignicons.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'

export default defineNuxtPlugin((app) => {
    const vuetify = createVuetify({components: Components});
    app.vueApp.use(vuetify);
});