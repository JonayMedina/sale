
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
// 


Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('category', require('./components/Category.vue').default);

Vue.component('client', require('./components/Client.vue').default);

Vue.component('product', require('./components/Product.vue').default);

Vue.component('user', require('./components/User.vue').default);

Vue.component('provider', require('./components/Provider.vue').default);

Vue.component('role', require('./components/Role.vue').default);

Vue.component('purchase', require('./components/Purchase.vue').default);

Vue.component('findp', require('./components/FindPurchase.vue').default);

Vue.component('sale', require('./components/Sale.vue').default);

Vue.component('finds', require('./components/FindSale.vue').default);

Vue.component('dash', require('./components/Dashboard.vue').default);

Vue.component('ret', require('./components/retention.vue').default);

Vue.component('quota', require('./components/Quota.vue').default);

Vue.component('company', require('./components/Company.vue').default);

Vue.component('tax', require('./components/Tax.vue').default);

Vue.component('buy', require('./components/Buy.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data : {
    	menu : 0
    }
});
