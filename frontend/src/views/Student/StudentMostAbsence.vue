<template>
  <v-btn class="mt-10 elevation-4" color="teal-darken-4" outlined block
    >STUDENT MOST ABSENCE LIST</v-btn
  >
  <v-table elevation-6 fixed-header height="300px" class="mt-2 mb-10 table">
    <thead class="t-head bg-primary" style="background-color: aqua">
      <tr class="tr">
        <th class="text-subtitle-1">Full name</th>
        <th class="text-subtitle-1">Gender</th>
        <th class="text-subtitle-1">Email</th>
        <th class="text-subtitle-1">Total</th>
        <th class="text-subtitle-1"></th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="user in filteredAttendanceMostAbsencData" :key="user.id">
        <td class="text-subtitle-1">
          <v-avatar size="large">
            <v-img :src="user.profile" alt="Avatar" cover> </v-img>
          </v-avatar>
          {{ user.first_name }} {{ user.last_name }}
        </td>
        <td class="text-subtitle-1">{{ user.gender }}</td>
        <td class="text-subtitle-1">{{ user.email }}</td>
        <td class="text-subtitle-1">{{ user.role_attendances_count }}</td>
        <td class="text-subtitle-1">
          <v-btn
            color="teal-darken-4"
            :to="'/studentattendancedetail/' + user.id"
          >
            Details<v-icon class="mt-1 ms-1">mdi-eye</v-icon></v-btn
          >
        </td>
      </tr>
    </tbody>
  </v-table>
</template>
<script>
import http from "@/htpp.common";
export default {
  data() {
    return {
      user: [],
      attendanceMostAbsencData: [], // Define the attendanceMostAbsencData array here
    };
  },
  mounted() {
    this.getMostAbsentStudents();
  },
  computed: {
    filteredAttendanceMostAbsencData() {
      return this.attendanceMostAbsencData.filter(
        (user) => user.role_attendances_count > 0
      );
    },
  },
  methods: {
    async getMostAbsentStudents() {
      try {
        const response = await http.get("/get-most-absence-student");
        this.attendanceMostAbsencData = response.data;
      } catch (error) {
        console.log(error);
      }
    },
  },
};
</script>

<style scoped></style>
