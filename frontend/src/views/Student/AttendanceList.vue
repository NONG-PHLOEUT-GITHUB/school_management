<template>
  <admin-dashboard v-if="this.role === '1'"></admin-dashboard>
  <teacher-dashboard v-else-if="this.role === '2'"></teacher-dashboard>
  <main class="table">
    <h3>Student Attendance List</h3>
    <v-table class="mt-4">
      <thead>
        <tr>
          <th class="text-white ">Id</th>
          <th class="text-white">First Name</th>
          <th class="text-white">Last Names</th>
          <th class="text-white">Total Absence</th>
          <th class="text-white">See More</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(attendanceItem, index) in attendanceData" :key="index">
          <td class="text-subtitle-1">{{ index + 1 }}</td>
          <td class="text-subtitle-1">{{ attendanceItem.first_name }}</td>
          <td class="text-subtitle-1">{{ attendanceItem.last_name }}</td>
          <td class="text-subtitle-1">{{ attendanceItem.role_attendances_count }}</td>
          <td>
            <v-btn
              class="status" color="teal-darken-4"
              :to="{ path: '/studentattendancedetail/' + attendanceItem.id }"
              >See Details <v-icon class="mt-1 ms-1">mdi-eye</v-icon></v-btn
            >
          </td>
        </tr>
      </tbody>
    </v-table>
  </main>
</template>
<script>
import http from "@/htpp.common";
import Cookies from "js-cookie";
export default {
  data() {
    return {
      attendanceData: [],
      role: "",
    };
  },
  methods: {
    getStudents(id) {
      http
        .get(`/getAllStudents/${id}`)
        .then((response) => {
          this.attendanceData = response.data.data;
          this.attendanceData = response.data.data;
          this.attendanceData.forEach((element) => {
            this.attendanceData = element.students;
          });
          console.log(this.attendanceData);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    fetchData() {
      http.get("/getAttendance").then((response) => {
        this.attendanceData = response.data;
        // console.log(response.data);
      });
    },
    getRole() {
      let cookies = Cookies.get("user_role");
      this.role = cookies;
    },
  },
  mounted() {
    const id = this.$route.params.id;
    this.getStudents(id);
    this.getRole();
  },
};
</script>

<style scoped>
* thead th {
  position: sticky;
  top: 0;
  left: 0;
  background-color:#004D40;
  cursor: pointer;
  text-transform: uppercase;
  color: white;
  font-size: 15px;
  font-weight: bold;
}

tbody tr:hover {
  background-color: #fff6 !important;
}
.status.detail {
  padding: 10px;
  margin-left: 10px;
  border-radius: 10px;
  background-color: #0000ff;
  color: white;
  font-weight: bold;
}
thead th:hover {
  color: #e8e8fa;
}
main {
  width: 80%;
  margin-left: 20%;
  margin-top: 20px;
}
</style>
