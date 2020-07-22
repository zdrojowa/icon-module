import Vue from 'vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';

window.axios = require('axios');

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

Vue.component('media-selector', require('./components/media-selector.vue').default);
Vue.component('icon', require('./components/icon.vue').default);

const app = new Vue({
    el: '#app'
});

