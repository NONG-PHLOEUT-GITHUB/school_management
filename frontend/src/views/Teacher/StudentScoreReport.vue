<template>
  <admin-dashboard v-if="this.role === '1'"></admin-dashboard>
  <teacher-dashboard v-else-if="this.role === '2'"></teacher-dashboard>
  <div class="main mt-3">
    <h3 class="text">Score monthly reports</h3>
    <div class="table-responsive">
      <table class="table table-hover table-nowrap">
        <thead class="thead">
          <tr>
            <th class="fs-7 text-white">NO</th>
            <th class="fs-7 text-white">Name</th>
            <th class="fs-7 text-white">Gender</th>
            <th class="fs-7 text-white">Khmer</th>
            <th class="fs-7 text-white">Math</th>
            <th class="fs-7 text-white">Eng</th>
            <th class="fs-7 text-white">His</th>
            <th class="fs-7 text-white">Bio</th>
            <th class="fs-7 text-white">Geo</th>
            <th class="fs-7 text-white">Es</th>
            <th class="fs-7 text-white">Mc</th>
            <th class="fs-7 text-white">C</th>
            <th class="fs-7 text-white">P</th>
            <th class="fs-7 text-white">Sport</th>
            <th class="fs-7 text-white">ICT</th>
            <th class="fs-7 text-white">Total</th>
            <th class="fs-7 text-white">Average</th>
            <th class="fs-7 text-white">Grade</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(student, index) of allStudents" :key="index">
            <td>{{ index + 1 }}</td>
            <td>{{ student.first_name + " " + student.last_name }}</td>
            <td>{{ student.gender }}</td>

            <td v-for="scores of student.scores" :key="scores">
              {{ scores.score }}
            </td>

            <td v-if="student.scores.length > 0 && getTotal(student.id) > 350" class="font-weight-bold text-green">
              {{ getTotal(student.id) }}
            </td>
            <td v-else class="font-weight-bold text-red">
              {{ getTotal(student.id) }}
            </td>

            <td v-if="student.scores.length > 0 && getAverage(student.id) > 25.0" class="font-weight-bold text-green">
              {{ getAverage(student.id) }}
            </td>
            <td v-else class="font-weight-bold text-red">
              {{ getAverage(student.id) }}
            </td>

            <td v-if="getAverage(student.id) < 25.0" class="font-weight-bold text-red">
              F
            </td>
            <td v-if="getAverage(student.id) >= 25 && getAverage(student.id) < 30" class="font-weight-bold text-green">
              E
            </td>
            <td v-if="getAverage(student.id) >= 30 && getAverage(student.id) < 35" class="font-weight-bold text-green">
              D
            </td>
            <td v-if="getAverage(student.id) >= 35 && getAverage(student.id) < 40" class="font-weight-bold text-green">
              C
            </td>
            <td v-if="getAverage(student.id) >= 40 && getAverage(student.id) < 47" class="font-weight-bold text-green">
              B
            </td>
            <td v-if="getAverage(student.id) >= 47 && getAverage(student.id) <= 50
              " class="font-weight-bold text-green">
              A
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
import http from "@/htpp.common";
import Cookies from "js-cookie";
export default {
  data() {
    return {
      allStudents: [],
      tab: 1,
      role: "",
    };
  },
  computed: {
    months() {
      return [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
      ];
    },
  },
  methods: {
    getStudents(id) {
      http
        .get(`/getAllStudents/${id}`)
        .then((response) => {
          this.allStudents = response.data.data;
          this.allStudents.forEach((element) => {
            console.log(element.students);
            this.allStudents = element.students;
          });
          console.log(this.allStudents);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getTotal(id) {
      let total = 0;
      this.allStudents.forEach((student) => {
        if (student.id == id) {
          student.scores.forEach((element) => {
            total += element.score;
          });
        }
      });
      return total;
    },
    getAverage(id) {
      return (this.getTotal(id) / 14).toFixed(3);
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
.main {
  width: 80%;
  margin-left: 19%;
}

.thead {
  background: #004D40;
}
</style>

