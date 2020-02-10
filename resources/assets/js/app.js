


require('./bootstrap');



window.Vue = require('vue');


Vue.component('filter-component', require('./components/FilterComponent.vue').default);

Vue.component('like-component', require('./components/LikeComponent.vue').default);
const app = new Vue({
    el: '#app',
});
