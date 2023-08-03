<template>
  <main-dashboard :menubar="menubar"></main-dashboard>
</template>

<script>
export default {
  data: () => ({
    menubar: [
      {
        path: "/admin-dashboard",
        title: "Dashboard",
        icon: "mdi-home",
      },
      {
        path: "/teacher_list",
        title: "teacher list",
        icon: "mdi-format-list-bulleted",
      },
      {
        path: "/guardian-list",
        title: "guardian list",
        icon: "mdi-format-list-bulleted",
      },
      {
        path: "/student_list",
        title: "Student list",
        icon: "mdi-format-list-bulleted",
      },
      {
        path: "/student-list",
        title: "Add user",
        icon: "mdi-plus",
      },
      // {
      //   path: '/student-attendance',
      //   title: "Attendance",
      //   icon: 'mdi-progress-check'
      // },
      // {
      //   path: "/student-acadamice",
      //   title: "Score",
      //   icon: "mdi-chart-bar",
      // },
      {
        path: "/class_list",
        title: "Class",
        icon: "mdi-clipboard-text",
      },
    ],
    userProfile: [
      {
        path: "/user-profile",
        title: "Class",
        icon: "mdi-clipboard-text",
      },
    ],
  }),
};
</script>
