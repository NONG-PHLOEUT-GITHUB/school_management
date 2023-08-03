<template>
  <admin-dashboard></admin-dashboard>
  <div class="card-container">
    <v-row class="mt-7 ms-24">
      <v-card
        width="400"
        class="me-2 user-total elevation-4"
        prepend-icon="mdi-account-tie"
      >
        <template v-slot:title>Students </template>

        <v-card-text
          class="card-text"
          v-for="(result, index) in results"
          :key="index"
        >
          <h5 v-if="result.role == 3">
            Total : {{ result.total }}
            <v-spacer></v-spacer>
            Male: {{ result.male }}
            <v-spacer></v-spacer>
            Female: {{ result.female }}
          </h5>
        </v-card-text>
      </v-card>
      <v-card
        width="400"
        class="user-total me-4 elevation-4"
        prepend-icon="mdi-account"
      >
        <template v-slot:title>Teachers </template>
        <v-card-text
          class="card-text"
          v-for="(result, index) in results"
          :key="index"
        >
          <h5 v-if="result.role == 2">
            Total : {{ result.total }}
            <v-spacer></v-spacer>
            Male: {{ result.male }}
            <v-spacer></v-spacer>
            Female: {{ result.female }}
          </h5>
        </v-card-text>
      </v-card>
      <v-card
        width="400"
        class="ms-4 user-total elevation-4"
        prepend-icon="mdi-school"
      >
        <template v-slot:title> Class </template>

        <v-card-text class="ms-14">
          <h5>Total : {{ classroom }}</h5>
        </v-card-text>
      </v-card>
    </v-row>
  </div>

  <main class="main mt-6">
    <h3>REPORTS</h3>
    <v-row class="mt-8">
      <v-card class="bar1 ms-4 elevation-4">
        <Bar id="my-chart-id" :options="chartOptions" :data="chartData" />
        <h5 class="text-center m-3">STUDENT ATTENDANCE</h5>
      </v-card>
      <v-card class="bar2 ms-4 elevation-4">
        <Bar id="my-chart-id" :options="chartOptions" :data="chartData1" />
        <h5 class="text-center m-3">FAILED STUDENT</h5>
      </v-card>
    </v-row>
  </main>

  <main class="main mt-6">
    <StudentMostAbsence></StudentMostAbsence>
  </main>
</template>

<script>
import { Bar } from "vue-chartjs";
import http from "../../htpp.common";
import StudentMostAbsence from "../Student/StudentMostAbsence.vue";
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from "chart.js";

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
);

export default {
  name: "BarChart",
  components: {
    StudentMostAbsence,
    Bar 
  },
  data() {
    return {
      results: "",
      classroom: "",
      attendance: "",
      chartData: {
        labels: [
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
        ],
        datasets: [
          {
            label: "Attendance average",
            data: [],
          },
        ],
      },
      chartData1: {
        labels: [
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
        ],
        datasets: [
          {
            label: "Percentage of failed students(%)",
            data: [],
          },
        ],
      },
      chartOptions: {
        backgroundColor: "teal",
        responsive: true,
      },
    };
  },

  mounted() {
    this.fetchTotalData();
    this.fetchFailedStudentData();
    this.fetchTotalOfClass();
    this.showGraphOfStudentAttendance();
  },

  methods: {
    async fetchTotalData() {
      try {
        const response = await http.get("/getTotal");
        this.results = response.data.data;
      } catch (error) {
        console.log(error);
      }
    },
    async fetchTotalOfClass() {
      try {
        const response = await http.get("/classrooms-total");
        this.classroom = response.data.data;
      } catch (error) {
        console.log(error);
      }
    },

    async fetchFailedStudentData() {
      try {
        const response = await http.get("/show-graph-of-student-fail");
        const mydata = response.data.failed_users_percentage;
        for (let i = 0; i < mydata.length; i++) {
          this.chartData1.datasets[0].data[i] = mydata[i];
        }
      } catch (error) {
        console.log(error);
      }
    },

    async showGraphOfStudentAttendance() {
      try {
        const response = await http.get("/show-grahp-of-student-attendance");
        const mydata = Object.values(response.data);
        for (let i = 0; i < mydata.length; i++) {
          this.chartData.datasets[0].data[i] = mydata[i];
        }
      } catch (error) {
        console.error(error);
      }
    },
  },
};
</script>
<style scoped>
@import url(https://unpkg.com/@webpixels/css@1.1.5/dist/index.css);

/* Bootstrap Icons */
@import url("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css");

.main {
  margin-left: 18%;
  margin-right: 10px;
}

.card-container {
  padding: 10px;
  margin-left: 11%;
}

.card-text {
  margin-top: -25px;
  margin-left: 60px;
}

.bar1 {
  width: 48%;
  border-left: solid teal 5px;
}

.bar2 {
  width: 49%;
  border-left: solid teal 5px;
}

h3 {
  margin-bottom: 20px;
  text-transform: uppercase;
  color: #0000ff;
}
.text-center {
  color: rgb(2, 74, 74);
}

.user-total {
  border-left: solid teal 5px;
}

.table {
  border-left: solid teal 5px;
  border-radius: 10px;
}

.th {
  color: red;
  font-weight: 200;
}

.img {
  width: 50%;
}

h3 {
  color: teal;
}
</style>
