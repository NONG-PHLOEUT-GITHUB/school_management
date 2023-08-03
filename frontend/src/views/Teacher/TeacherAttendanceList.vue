<template>
  <main class="table">
    <h3>Teacher Attendance List</h3>
    <table>
      <thead>
        <tr>
          <th>Id</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Total Absence</th>
          <th>See More</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="attendanceItem in attendanceData" :key="attendanceItem.id">
          <td>{{ attendanceItem.id }}</td>
          <td>{{ attendanceItem.first_name }}</td>
          <td>{{ attendanceItem.last_name }}</td>
          <td>{{ attendanceItem.role_attendances_count }}</td>
          <td>
            <router-link
              class="status detail"
              :to="{ path: '/teacherattendancedetail/' + attendanceItem.id }"
              >Detail</router-link
            >
          </td>
        </tr>
      </tbody>
    </table>
  </main>
</template>

<script>
import http from "@/htpp.common";
export default {
  data() {
    return {
      attendanceData: [],
    };
  },
  mounted() {
    http
      .get("/getTeacherAttendance")
      .then((response) => {
        this.attendanceData = response.data;
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: sans-serif;
}
body {
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}
main.table {
  margin: auto;
  border-radius: 10px;
  padding: 2%;
}
h3 {
  margin-bottom: 10px;
  text-transform: uppercase;
  color: #0000ff;
}
span {
  padding: 2%;
  text-transform: uppercase;
  color: #1b1e1d;
}
table {
  padding: 2%;
  width: 100%;
  box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
}

td img {
  width: 36px;
  height: 36px;
  margin-right: 0.5rem;
  border-radius: 50%;
  vertical-align: middle;
}

table,
th,
td {
  border-collapse: collapse;
  padding: 1rem;
  text-align: left;
}

thead th {
  position: sticky;
  top: 0;
  left: 0;
  background-color: #0000ff;
  cursor: pointer;
  text-transform: uppercase;
  color: white;
  font-size: 15px;
  font-weight: bold;
}

.status.detail {
  padding: 10px 25px;
  margin-left: 10px;
  border-radius: 3px;
  background-color: #0000ff;
  color: white;
  font-weight: bold;
}
thead th:hover {
  color: #e2f0ee;
}
</style>
