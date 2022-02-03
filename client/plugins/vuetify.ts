import { createVuetify } from "vuetify";
import * as Components from 'vuetify/components'

export default defineNuxtPlugin((app) => {
    const vuetify = createVuetify({components: Components});
    app.vueApp.use(vuetify);
});