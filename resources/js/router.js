import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

import Home from './component/home'
import Login from './admin/pages/login'
import User from './admin/pages/users'
import FirstPage from './component/page'
import Click from './component/click'
import Tags from './admin/pages/tags'
import Category from './admin/pages/category'
import Form from './component/form'

const routes = [
    {path: '/', name: 'home', component: Home},
    {path: '/login', name: 'login', component: Login},
    {path: '/tag', name: 'tag', component: Tags},
    {path: '/category', name: 'category', component: Category},
    {path: '/click', name: 'click', component: Click},
    {path: '/users', name: 'user', component: User},
    {path: '/slots', name: 'slots', component: FirstPage},
    {path: '/form', name: 'form', component: Form},
]

export default new Router({
    mode: 'history',
    routes: routes
})
