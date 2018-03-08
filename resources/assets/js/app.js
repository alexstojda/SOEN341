
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.SimpleMDE = require('simplemde');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('dashboard-notification', require('./components/DashboardNotification.vue'));
Vue.component('status-toast', require('./components/StatusToast.vue'));
Vue.component('vote', require('./components/VoteComponent.vue'));

const app = new Vue({
    el: '#app'
});

