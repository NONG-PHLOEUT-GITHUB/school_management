<template>
  <admin-dashboard></admin-dashboard>
  <main class="table">
    <h3>
      Attendance Records for
      <span> {{ user.first_name }} {{ user.last_name }}</span>
    </h3>
    <table>
      <thead>
        <tr>
          <th>date</th>
          <th>reason</th>
          <th>attendance status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="record in attendanceRecords" :key="record.id">
          <td>{{ record.date }}</td>
          <td>{{ record.reason }}</td>
          <td>{{ record.attendance_status }}</td>
        </tr>
      </tbody>
    </table>
  </main>
</template>
<script>
import axios from "axios";

export default {
  data() {
    return {
      user: {},
      attendanceRecords: [],
      URL: "http://127.0.0.1:8000/api/getteacherDetail",
    };
  },
  methods: {
    listattendance(id) {
      axios
        .get(this.URL + "/" + `${id}`)
        .then((response) => {
          this.user = response.data.user;
          this.attendanceRecords = response.data.attendanceRecords;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    const id = this.$route.params.id;
    this.listattendance(id);
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
  width: 80%;
  margin-left: 18%;
  margin-top: 10px;
}
h3 {
  margin-bottom: 20px;
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
thead th:hover {
  color: #e2f0ee;
}
</style>