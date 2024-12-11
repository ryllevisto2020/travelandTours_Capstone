import { createVuetify } from 'vuetify';
import { VBtn } from 'vuetify/components/VBtn';
import defaults from './defaults';
import { icons } from './icons';
import { themes } from './theme';
import { VDateInput } from 'vuetify/labs/VDateInput';
import { VForm } from 'vuetify/components/VForm';
import VueDatePicker from '@vuepic/vue-datepicker'; // Import VueDatePicker
import '@core-scss/template/libs/vuetify/index.scss';
import '@vuepic/vue-datepicker/dist/main.css'; // Import VueDatePicker styles
import 'vuetify/styles';

export default function (app) {
  const vuetify = createVuetify({
    aliases: {
      IconBtn: VBtn,
    },
    components: {
      VDateInput, // Vuetify date input
      VForm,
      VueDatePicker, // Register VueDatePicker
    },
    defaults,
    icons,
    theme: {
      defaultTheme: 'light',
      themes,
    },
  });

  app.use(vuetify);
}
