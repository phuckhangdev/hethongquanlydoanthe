
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';
window.moment = moment;

import datePicker from 'vue-bootstrap-datetimepicker';
Vue.use(datePicker);

// Initialize as global component
Vue.component('date-picker', datePicker);

// Using font-awesome 5 icons
$.extend(true, $.fn.datetimepicker.defaults, {
  icons: {
    time: 'fas fa-clock',
    date: 'fas fa-calendar',
    up: 'fas fa-arrow-up',
    down: 'fas fa-arrow-down',
    previous: 'fas fa-chevron-left',
    next: 'fas fa-chevron-right',
    today: 'fas fa-calendar-check',
    clear: 'fas fa-trash-alt',
    close: 'fas fa-times-circle'
  }
});

import vSelect from 'vue-select'
Vue.component('v-select', vSelect)
// Using sweetalert
import swal from 'sweetalert2';
window.swal = swal;
const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;

import { Form, HasError, AlertError } from 'vform';

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

import VueProgressBar from 'vue-progressbar';

Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '2px'
})

import VueRouter from 'vue-router'
Vue.use(VueRouter)

let routes = [
    { path: '/chidoan', component: require('./components/Chidoan.vue') },
    { path: '/doankhoato', component: require('./components/Doankhoato.vue') },
    { path: '/captochuc', component: require('./components/Captochuc.vue') },
    { path: '/hoatdong', component: require('./components/Hoatdong.vue') },
    { path: '/khenthuong', component: require('./components/Khenthuong.vue') },
    { path: '/kyluat', component: require('./components/kyluat.vue') },
  ]

const router = new VueRouter({
    mode: 'history',
    routes,
    linkActiveClass: 'active'
  })

window.Fire = new Vue();  

// Filter and Show custom text to client
Vue.filter('upText', function(text) {
  return text.charAt(0).toUpperCase() + text.slice(1)
})
// Filter and Show custome datetime to client
Vue.filter('showDate', function(created) {
  // return moment(created).format('DD/MM/YYYY, h:mm:ss a')
  return moment(created).format('DD/MM/YYYY, HH:mm')
})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component(
  'passport-clients',
  require('./components/passport/Clients.vue')
);

Vue.component(
  'passport-authorized-clients',
  require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
  'passport-personal-access-tokens',
  require('./components/passport/PersonalAccessTokens.vue')
);

Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const files = require.context('./', true, /\.vue$/i)

// files.keys().map(key => {
//     return Vue.component(_.last(key.split('/')).split('.')[0], files(key))
// })

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    data: {
      moment: moment
    },
});
