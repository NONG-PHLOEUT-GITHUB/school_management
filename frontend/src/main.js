import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css'
import '@fortawesome/fontawesome-free/css/all.css'

/// main dashboard=======================================================

import MainDashboard from '@/components/MainDashboard'
import AdminDashboard from '@/components/AdminDashboard'
import TeacherDashboard from '@/components/TeacherDashboard'
import StudentDashboard from '@/components/StudentDashboard'

const vuetify = createVuetify({
  components,
  directives,
})

const app = createApp(App);

app.component('main-dashboard',MainDashboard);
app.component('admin-dashboard',AdminDashboard);
app.component('teacher-dashboard',TeacherDashboard);
app.component('student-dashboard',StudentDashboard);

app.use(createPinia()).use(router).use(vuetify).mount('#app')
