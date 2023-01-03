import Vue from 'vue'
import PortalVue from 'portal-vue'
import { InertiaProgress } from '@inertiajs/progress'
import { createInertiaApp } from '@inertiajs/inertia-vue'
import "leaflet/dist/leaflet.css";
import "leaflet-geosearch/dist/geosearch.css";
import 'tw-elements';
import VueSweetalert2 from 'vue-sweetalert2';

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(VueSweetalert2);

Vue.config.productionTip = false
Vue.use(PortalVue)

InertiaProgress.init()

createInertiaApp({
  resolve: name => require(`./Pages/${name}`),
  title: title => title ? `${title} - WakafKu` : 'WakafKu',
  setup({ el, app, props, plugin }) {
    Vue.use(plugin)
    new Vue({ render: h => h(app, props) })
      .$mount(el)
  },
})
