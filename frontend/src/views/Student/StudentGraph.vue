<template>
  <main class="main mt-6">
    <h3>REPORTS</h3>
    <v-row class="mt-8">
      <v-card class="bar1">
        <Bar id="my-chart-id" :options="chartOptions" :data="chartData" />
        <h5 class="text-center m-3 text-warning">ATTENDANCE</h5>
      </v-card>
      <v-card class="bar2 ms-4">
        <Bar id="my-chart-id" :options="chartOptions" :data="chartData1" />
        <h5 class="text-center m-3 text-warning">SCORE</h5>
      </v-card>
    </v-row>
  </main>
</template>
<script>
import http from "@/htpp.common.js";
import { Bar } from "vue-chartjs";
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
  components: { Bar },
  data() {
    return {
      userId: null,
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
            label: "Attendance",
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
            label: "Average Score",
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
    http
      .get("/v1/auth/user")
      .then((response) => {
        this.userId = response.data.data.id;
        this.fetchAttendanceData();
        this.fetchScoreData();
      })
      .catch((error) => {
        console.error(error);
      });
  },
  methods: {
    fetchAttendanceData() {
      http
        .get(`/getstudentattendanceeverymonth/${this.userId}`)
        .then((response) => {
          const mydata = Object.values(response.data);
          for (let i = 0; i < mydata.length; i++) {
            this.chartData.datasets[0].data[i] = mydata[i];
          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
    fetchScoreData() {
      http
        .get(`/getStudentScoreEveryMonth/${this.userId}`)
        .then((response) => {
          const mydata = Object.values(response.data.average_scores);
          for (let i = 0; i < mydata.length; i++) {
            this.chartData1.datasets[0].data[i] = mydata[i];
          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
};
</script>

<style scoped>
.main {
  margin-left: 19%;
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
}
.bar2 {
  width: 49%;
}
</style>
