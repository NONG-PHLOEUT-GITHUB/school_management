<template>
  <teacher-dashboard></teacher-dashboard>
  <div class="main">
    <div class="text-center">
      <v-snackbar v-model="snackbar" multi-line>
        {{ text }}
        <template v-slot:actions>
          <v-btn color="teal" variant="text" @click="snackbar = false">
            Close
          </v-btn>
        </template>
      </v-snackbar>
    </div>

    <v-btn block variant="outlined" size="large" color="">Class list</v-btn>

    <v-card 
      v-for="classroom of classrooms"
      :key="classroom"
      class="card mx-auto mt-2"
      width="96%"
      prepend-icon="mdi-home"
      elevation="4"
    >
      <template v-slot:title> Grade : {{ classroom.class_name }}</template>
      <div class="action">
        <v-col cols="auto">
          <v-btn  color="teal-darken-4"
            :to="{ path: '/student-score-report/' + classroom.id }"
            class="me-4"
          >
            <v-icon>mdi-chart-line</v-icon> Score report
          </v-btn>
          <v-btn  color="teal-darken-4" :to="{ path: '/attendance_list/' + classroom.id }">
            <v-icon>mdi-calendar-clock</v-icon> Attendance report
          </v-btn>
          <v-btn  color="teal-darken-4" :to="{ path: '/feedback/' + classroom.id }" class="ms-4">
            <v-icon>mdi-poll</v-icon> Studen feedback
          </v-btn>
        </v-col>
      </div>
    </v-card>
  </div>
</template>

<script>
// https://snyk.io/advisor/npm-package/lru-cache/functions/lru-cache
import http from "@/htpp.common";
import LRU from "lru-cache";

const cache = new LRU(100);

export default {
  data() {
    return {
      classrooms: [],
      class_name: "",
      snackbar: false,
      text: `You do not have the class yet.`,
    };
  },
  methods: {
    async getTeacherClassroom() {
      const cachedResponse = cache.get("teacher_classroom");

      if (cachedResponse) {
        this.classrooms = cachedResponse;
        return;
      }

      try {
        const response = await http.get("/v1/auth/user");
        this.classrooms = response.data.data.class_teacher;
        cache.set("teacher_classroom", this.classrooms);
      } catch (error) {
        console.error(error);
      }
      if (this.classrooms.length === 0) {
        this.snackbar = true;
      }
    },
  },
  mounted() {
    this.getTeacherClassroom();
  },
};
</script>

<style scoped>
.main {
  margin-left: 18%;
  margin-top: 15px;
}

.card{
  border-left: solid 5px #004D40;
}
</style>
