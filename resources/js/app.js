require('./bootstrap');

window.Vue = require('vue').default;
import VueCharts from 'vue-chartjs';

Vue.use(VueCharts);

Vue.component('example-component', require('./components/ModelsTable.vue').default);


const app = new Vue({
    el: '#app',
});
