import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView/LoginView.vue'
import DashboardView from '../views/DashboardView/DashboardView.vue'
import BookNewView from '../views/DashboardView/Books/BookNewView.vue'
import { useUserStore } from '../stores/user'
import AuthorNewView from '@/views/Author/AuthorNewView.vue'
import AuthorsListView from '@/views/Author/AuthorsListView.vue'
import SubjectListView from '@/views/Subject/SubjectListView.vue'
import SubjectNewView from '@/views/Subject/SubjectNewView.vue'

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: LoginView,
  },
  {
    path: '/',
    name: 'Dashboard',
    component: DashboardView,
    meta: { requiresAuth: true },
  },
  {
    path: '/books/new',
    name: 'BookCreate',
    component: BookNewView,
    meta: { requiresAuth: true }
  },
  {
    path: "/authors",
    name: "AuthorList",
    component: AuthorsListView,
    meta: { requiresAuth: true }
  },
  {
    path: '/authors/new',
    name: 'AuthorCreate',
    component: AuthorNewView,
    meta: { requiresAuth: true }
  }, 
  {
    path: "/subjects",
    name: "SubjectList",
    component: SubjectListView,
    meta: { requiresAuth: true }
  },
  {
    path: '/subjects/new',
    name: 'SubjectCreate',
    component: SubjectNewView,
    meta: { requiresAuth: true }
  },   
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach(async (to, from, next) => {
  const store = useUserStore()

  if (!store.user && localStorage.getItem('token')) {
    await store.fetchUser()
  }

  if (to.meta.requiresAuth && !store.isAuthenticated) {
    next('/login')
  } else {
    next()
  }
})

export default router