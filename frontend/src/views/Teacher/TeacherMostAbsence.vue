<template>
  <main class="table">
    <h3>Teacher Most Absence List</h3>
    <table>
      <thead class="no">
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Total Absence</th>
          <th>See More</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="attendanceItem in attendanceData" :key="attendanceItem.id">
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
import htpp from '@/htpp.common'

export default {
  data() {
    return {
      attendanceData: [],
    };
  },
  mounted() {
    htpp
      .get('/getTeacherMostAbsence')
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
  margin-bottom: 20px;
  text-transform: uppercase;
  color: #0000ff;
}
table {
  padding: 2%;
  width: 100%;
  box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
}
table,th,td {
  border-collapse: collapse;
  padding: 1rem;
  text-align: left;
}
td {
  font-weight: bold;
  font-size: 15px;
}
.no {
  position: sticky;
  top: 0;
  left: 0;
  background-color: #0000ff;
  cursor: pointer;
  text-transform: uppercase;
  color: white;
  font-size: 16px;
  font-weight: bold;
}
.status.detail {
  padding: 10px 25px;
  margin-left: 10px;
  border-radius: 3px;
  background-color: #0000FF;
  color: white;
  font-weight: bold;
}
</style>