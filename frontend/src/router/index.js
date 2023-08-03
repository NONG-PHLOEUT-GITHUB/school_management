import { createRouter, createWebHistory } from 'vue-router'
import Cookies from 'js-cookie';
//admind dashboard router =================================================================
import DashboardHomeView from '@/views/Director/DirectorDashboard.vue';
import AddGuardian from '../views/Guardians/CreateGuardian.vue';
// import EditGuardian from '../views/Guardians/EditGuardian.vue';
import EditGuardian from '@/views/Guardians/EditGuardian.vue';
//admind dashboard router =================================================================
import TeacherListView from '../views/Teacher/SaveListTeacher.vue';
import StudentList from '../views/Student/StudentList.vue';
import ClassView from '../views/Director/ClassView.vue';
import CreateUserForm from '../views/Dashboard/CreateUserForm.vue';
import AttendanceList from '../views/Student/AttendanceList.vue';
import StudentGraph from '../views/Student/StudentGraph.vue';
import StudentMostAbsence from '../views/Student/StudentMostAbsence.vue';
import StudentDetail from '../views/Student/StudentDetial.vue';
import StudentAttendanceDetail from '../views/Student/StudentAttendanceDetail.vue';
import TeacherAttendanceDetail from '../views/Teacher/TeacherAttendanceDetail.vue';
import CheckAttendance from '../views/Student/CheckAttendance.vue'
import TeacherAttendanceList from '../views/Teacher/TeacherAttendanceList.vue';
import SaveListStudent from '@/views/Student/SaveListStudent.vue';
import TeacherDetail from '../views/Student/StudentDetial.vue'
import EditUserForm from '../views/Dashboard/EditUserForm.vue'
import GiveFeedBackForm from '../views/Teacher/GiveFeedBackForm.vue'
import StudentScoreReport from '../views/Teacher/StudentScoreReport.vue'
//authentication router =================================================================
import ResetNewPasswordForm from '@/views/Authentication/ResetNewPasswordForm.vue';
import LoginForm from '../views/Authentication/LoginForm.vue';
import ForgotPasswordFrom from '@/views/Authentication/ForgotPasswordForm.vue';
import ChangePasswordForm from '../views/Authentication/ChangePasswordForm.vue';
import NotFoundView from '@/views/Authentication/NotFoundView.vue';
//user router ===========================================================================
import UserProfile from '@/views/UserInfo/UserProfile.vue';
//dashboard router ======================================================================
import TeacherHome from '@/views/Teacher/TeacherHome.vue';
import StudentDashboard from '@/components/StudentDashboard.vue';
//student dashboard router ==============================================================
import StudentAcadmics from '@/views/Student/StudentView.vue';
import StudentHomeView from '@/views/Student/StudentHomeView';
import StudentAttendanceView from '@/views/Student/StudentAttendanceView.vue';
import StudentScoreView from '@/views/Student/StudentScoreView.vue';
import StudentScore from '@/views/Student/StudentScore.vue';
import StudentCommentView from '@/views/UserInfo/CommentView';

//teacher dashboard router =============================================================
import ClassroomView from '@/views/Teacher/ClassroomView.vue';

//guadian  router =============================================================
import GuardianListView from '../views/Guardians/GuardianList.vue';



const routes = [
  {
    path: '/',
    name: 'FristLoginForm',
    component: LoginForm,
  },
  {
    path: '/login',
    name: 'SecondLoginForm',
    component: LoginForm,
  },
  {
    path: '/reset-new-password/:token',
    name: 'ResetNewPasswordForm',
    component: ResetNewPasswordForm
  },
  {

    path: '/change-password',
    name: 'ChangePasswordForm',
    component: ChangePasswordForm,
    meta: { requiresAuth: true }
  },
    {
    path: '/forgot-password',
    name: 'FormFogetPassword',
    component: ForgotPasswordFrom
  },
    {
    path: '/user-profile',
    name: 'UserProfile',
    component: UserProfile,
    meta: {requiresAuth: true}
  },

  // =============================
  {
    path: '/student-home',
    name: 'StudentHomeView',
    component: StudentHomeView,
    meta: { requiresAuth: true, requiredRoles: [3] }
  },
  {
    path: '/student-comments',
    name: 'StudentCommentView',
    component: StudentCommentView,
    meta: { requiresAuth: true, requiredRoles: [3] }
  },
  {
    path: '/student-attendance',
    name: 'StudentAttendanceView',
    component: StudentAttendanceView,
    meta: { requiresAuth: true, requiredRoles: [1, 2] }
  },
  {
    path: '/student-scores',
    name: 'StudentScoreView',
    component: StudentScoreView,
    meta: { requiresAuth: true, requiredRoles: [1, 2] }
  },
  // =============================
  {
    path: '/student-acadamice',
    name: 'StudentAcadmics',
    component: StudentAcadmics,
    meta: { requiresAuth: true, requiredRoles: [1, 2] }
  },
  
// ============main dashboard=======
{
  path: '/admin-dashboard',
  name: 'DashboardHomeView',
  component: DashboardHomeView,
  meta: { requiresAuth: true, requiredRoles: [1] }
},

{
  path: '/teacher-dashboard',
  name: 'TeacherDashboard',
  component: TeacherHome,
  meta: { requiresAuth: true, requiredRoles: [1, 2] }
},
{
  path: '/student-dashboard',
  name: 'StudentDashboard',
  component: StudentDashboard,
  meta: { requiresAuth: true}
},

// ============main dashboard=======

  {
    path: '/student-list',
    name: 'StudentList',
    component: StudentList,
    meta: { requiresAuth: true, requiredRoles: [1, 2] }
  },
  {
    path: '/class_list',
    name: 'class_list',
    component: ClassView,
    meta: { requiresAuth: true, requiredRoles: [1, 2] }
  },
  {
    path: '/createUser',
    name: '/createUser',
    component: CreateUserForm,
    meta: { requiresAuth: true, requiredRoles: [1, 2] }
  },

  {
    path: '/studentmostabsence',
    name: '/studentmostabsence',
    component: StudentMostAbsence,
    meta: { requiresAuth: true, requiredRoles: [1, 2] }
  },
  {
    path: '/studentdetail',
    name: '/studentdetail',
    component: StudentDetail,
    meta: { requiresAuth: true, requiredRoles: [1, 2] }
  },
  {
    path: '/studentattendancedetail/:id',
    name: '/studentattendancedetail',
    component: StudentAttendanceDetail,
    meta: { requiresAuth: true, requiredRoles: [1, 2] }
  },
  {
    path: '/teacherattendancedetail/:id',
    name: '/teacherattendancedetail',
    component: TeacherAttendanceDetail,
    meta: { requiresAuth: true, requiredRoles: [1, 2] }
  },
  {
    path: '/check-attendance',
    name: '/checkAttendance',
    component: CheckAttendance,
    meta: { requiresAuth: true, requiredRoles: [1, 2] }
  },
  {
    path: '/teacherattendancelist',
    name: '/teacherattendancelist',
    component: TeacherAttendanceList,
    meta: { requiresAuth: true, requiredRoles: [1, 2] }
  },
  {
    path: '/student_list',
    name: 'student_list',
    component: SaveListStudent,
    meta: { requiresAuth: true, requiredRoles: [1, 2] }
  },
  {
    path: '/student_detail/:id',
    name: '/student_detail',
    component: TeacherDetail,
    meta: { requiresAuth: true, requiredRoles: [1, 2] }
  },
  {
    path: '/attendance_list/:id',
    name: 'attendance',
    component: AttendanceList,
    props: true,
    meta: { requiresAuth: true, requiredRoles: [1, 2] }
  },
  {
    name: 'edit',
    path: '/edit/:id',
    component: EditUserForm,
    meta: { requiresAuth: true, requiredRoles: [1, 2] }
  },
  {
    path: '/class_rooms/:id',
    name: 'class_rooms',
    meta: { requiresAuth: true, requiredRoles: [1, 2] }
  },
  {
    path: '/studentgraph',
    name: '/studentgraph',
    component: StudentGraph,
    meta: { requiresAuth: true, requiredRoles: [1, 2] }
  },
  {
    path: '/feedback/:id',
    name: 'feedback',
    component: GiveFeedBackForm,
    props: true,
    meta: { requiresAuth: true, requiredRoles: [1, 2] }
  },
  {
    path: '/student-score-report/:id',
    name: 'student-score-report',
    component: StudentScoreReport,
    props: true,
    meta: { requiresAuth: true, requiredRoles: [1, 2] }
  },
  {
    path: '/teacher-classroom',
    name: 'ClassroomView',
    component: ClassroomView,
    meta: { requiresAuth: true, requiredRoles: [1, 2] }
  },
  {
    path: '/student-score',
    name: 'StudentScore',
    component: StudentScore,
    meta: { requiresAuth: true, requiredRoles: [1, 2] }
  },
  {
    path: '/teacher_list',
    name: 'Teacher List',
    component: TeacherListView,
    meta: { requiresAuth: true, requiredRoles: [1] }
  },
  {
    path: '/guardian-list',
    name: 'GuardianList',
    component: GuardianListView,
    meta: { requiresAuth: true, requiredRoles: [1] }
  },
  {
    path: '/add-guadian',
    name: 'AddGuadian',
    component: AddGuardian,
    meta: { requiresAuth: true, requiredRoles: [1] }
  },
  {
    path: '/edit-guadian/:id',
    name: 'EditGuadian',
    component: EditGuardian,
    meta: { requiresAuth: true, requiredRoles: [1] }
  },
 
  {
    path: '/:pathMatch(.*)*', // matches any unknown path
    name: 'not-found',
    component: NotFoundView
  }

]

const router = createRouter({
  history: createWebHistory(process.env.VUE_APP_API_URL),
  routes
});

// https://beginnersoftwaredeveloper.com/how-do-i-protect-my-vue-router/?expand_article=1

router.beforeEach((to, from, next) => {

  const { isAuthenticated, role } = checkAuth();
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
  const requiredRole = to.meta.requiredRole;

  if (requiresAuth && !isAuthenticated) {
    next('/login');
  }
  else if (to.name === 'StudentDashboard') {
    next('/student-home');
  }
  else if (requiredRole && !requiredRole.includes(role)) {
    next('/login');
  }
   else {
    next();
  }
})

function checkAuth() {
  const token = Cookies.get('access_token');
  const role = Cookies.get('user_role');
  return { isAuthenticated: !!token, role: parseInt(role) };
}

export default router;