require('./bootstrap');

window.Vue = require('vue')
Vue.component('my-first', require('./component/main').default)

import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
Vue.use(ViewUI);

import router from './router'
import store from './store'

router.beforeEach((to, from, next) => {
    ViewUI.LoadingBar.start();
    next();
});

router.afterEach(route => {
    ViewUI.LoadingBar.finish();
});

import common from './common'
Vue.mixin(common)

const app = new Vue({
    el: '#app',
    router,
    store
})
