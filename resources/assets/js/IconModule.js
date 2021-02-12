import Vue from 'vue';
import {BootstrapVue, BootstrapVueIcons, IconsPlugin} from 'bootstrap-vue';
import VueRouter from 'vue-router'
import Index from './components/Index'
import Icon from './components/Icon'

window.axios = require('axios');

Vue.use(BootstrapVue)
Vue.use(BootstrapVueIcons)
Vue.use(VueRouter)

const app = document.getElementById('app');

new Vue({
    components: {Index, Icon},

    data() {
        return {
            search: '',
            items: []
        }
    },

    mounted() {
        this.find()
    },

    methods: {
        find() {
            let self = this
            axios.get('/api/icons?search=' + self.search)
            .then(function(response) {
                self.items = response.data
            }).catch(function(error) {
                console.log(error)
            })
        }
    }
}).$mount(app);