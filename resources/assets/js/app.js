/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')
window.SimpleMDE = require('simplemde')

window.Vue = require('vue')
window.marked = require('marked')

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(require('vue-simplemde'))

Vue.component('example-component', require('./components/ExampleComponent.vue'))
Vue.component('dashboard-notification', require('./components/DashboardNotification.vue'))
Vue.component('status-toast', require('./components/StatusToast.vue'))
Vue.component('vote', require('./components/vote/VoteComponent.vue'))
Vue.component('comments', require('./components/comment/CommentsComponent.vue'))
Vue.component('answers', require('./components/answer/AnswersComponent.vue'))
Vue.component('select-answer', require('./components/answer/SelectAnswerComponent.vue'))
Vue.component('question', require('./components/question/QuestionComponent.vue'))
Vue.component('questions-top', require('./components/question/QuestionsListComponent.vue'))

const app = new Vue({
  el: '#app'
})

