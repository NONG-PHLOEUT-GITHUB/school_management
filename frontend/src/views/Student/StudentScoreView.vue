<template>
  <student-dashboard />
  <h3 class="title mb-2 mt-4">MY SCORES RECORDS</h3>
  <v-card class="card mt-3">
    <v-tabs v-model="tab" bg-color="teal-darken-4" center-active>
      <v-tab
        v-for="(month, index) in monthsWithAttendance"
        :key="month"
        :value="index + 1"
      >
        {{ month }}
      </v-tab>
    </v-tabs>
  </v-card>

  <v-card-text class="card">
    <v-window v-model="tab">
      <v-window-item
        v-for="month in scoresByMonthWithSummary"
        :key="month.month"
        :value="month.month"
      >
        <div class="table-responsive">
          <table class="table table-hover table-nowrap mt-2">
            <thead class="thead">
              <tr>
                <th scope="col" class="text-subtitle-1 text-light">Subject</th>
                <th scope="col" class="text-subtitle-1 text-light">Score</th>
                <th scope="col" class="text-subtitle-1 text-light">Grade</th>
                <th scope="col" class="text-subtitle-1 text-light">Status</th>
              </tr>
            </thead>
            <tbody>
              <template v-if="month.scores.length === 0">
                <tr>
                  <td colspan="5" class="text-center text-md text-dark">
                    There is no score yet in this month
                  </td>
                </tr>
              </template>
              <template v-else>
                <tr
                  v-for="score of month.scores"
                  :key="score.id"
                  class="border-2-dark"
                >
                  <!-- <td class="text-subtitle-1 text-black">{{ score.subject_id }}</td> -->
                  <td v-if="score.subject_id == 1" class="text-subtitle-1">
                    Khmer
                  </td>
                  <td v-if="score.subject_id == 2" class="text-subtitle-1">
                    Math
                  </td>
                  <td v-if="score.subject_id == 3" class="text-subtitle-1">
                    English
                  </td>
                  <td v-if="score.subject_id == 4" class="text-subtitle-1">
                    History
                  </td>
                  <td v-if="score.subject_id == 5" class="text-subtitle-1">
                    Biology
                  </td>
                  <td v-if="score.subject_id == 6" class="text-subtitle-1">
                    Geography
                  </td>
                  <td v-if="score.subject_id == 7" class="text-subtitle-1">
                    Earth Science
                  </td>
                  <td v-if="score.subject_id == 8" class="text-subtitle-1">
                    Morality-Civics
                  </td>
                  <td v-if="score.subject_id == 9" class="text-subtitle-1">
                    Chemisty
                  </td>
                  <td v-if="score.subject_id == 10" class="text-subtitle-1">
                    Physics
                  </td>
                  <td v-if="score.subject_id == 11" class="text-subtitle-1">
                    Sport
                  </td>
                  <td v-if="score.subject_id == 12" class="text-subtitle-1">
                    ICT (information communication technology)
                  </td>

                  <td
                    v-if="
                      (score.subject_id == 1 || score.subject_id == 2) &&
                      score.score < 50
                    "
                    class="text-subtitle-1 text-red"
                  >
                    {{ score.score }}
                  </td>
                  <td
                    v-if="
                      (score.subject_id == 1 || score.subject_id == 2) &&
                      score.score >= 50 &&
                      score.score < 80
                    "
                    class="text-subtitle-1 text-warning"
                  >
                    {{ score.score }}
                  </td>
                  <td
                    v-if="
                      (score.subject_id == 1 || score.subject_id == 2) &&
                      score.score >= 80 &&
                      score.score < 100
                    "
                    class="text-subtitle-1 text-green"
                  >
                    {{ score.score }}
                  </td>

                  <td
                    v-if="score.subject_id > 2 && score.score < 25"
                    class="text-subtitle-1 text-red"
                  >
                    {{ score.score }}
                  </td>
                  <td
                    v-if="
                      score.subject_id > 2 &&
                      score.score >= 25 &&
                      score.score < 40
                    "
                    class="text-subtitle-1 text-warning"
                  >
                    {{ score.score }}
                  </td>
                  <td
                    v-if="
                      score.subject_id > 2 &&
                      score.score >= 40 &&
                      score.score < 50
                    "
                    class="text-subtitle-1 text-green"
                  >
                    {{ score.score }}
                  </td>

                  <td
                    v-if="
                      (score.subject_id == 1 || score.subject_id == 2) &&
                      score.score < 50
                    "
                    class="text-subtitle-1 text-red"
                  >
                    F
                  </td>
                  <td
                    v-if="
                      (score.subject_id == 1 || score.subject_id == 2) &&
                      score.score >= 50 &&
                      score.score < 60
                    "
                    class="text-subtitle-1 text-warning"
                  >
                    E
                  </td>
                  <td
                    v-if="
                      (score.subject_id == 1 || score.subject_id == 2) &&
                      score.score >= 60 &&
                      score.score < 70
                    "
                    class="text-subtitle-1 text-warning"
                  >
                    D
                  </td>
                  <td
                    v-if="
                      (score.subject_id == 1 || score.subject_id == 2) &&
                      score.score >= 70 &&
                      score.score < 80
                    "
                    class="text-subtitle-1 text-warning"
                  >
                    C
                  </td>
                  <td
                    v-if="
                      (score.subject_id == 1 || score.subject_id == 2) &&
                      score.score >= 80 &&
                      score.score < 90
                    "
                    class="text-subtitle-1 text-green"
                  >
                    B
                  </td>
                  <td
                    v-if="
                      (score.subject_id == 1 || score.subject_id == 2) &&
                      score.score >= 90 &&
                      score.score < 100
                    "
                    class="text-subtitle-1 text-green"
                  >
                    A
                  </td>

                  <td
                    v-if="score.subject_id > 2 && score.score < 25"
                    class="text-subtitle-1 text-red"
                  >
                    F
                  </td>
                  <td
                    v-if="
                      score.subject_id > 2 &&
                      score.score >= 25 &&
                      score.score < 30
                    "
                    class="text-subtitle-1 text-warning"
                  >
                    E
                  </td>
                  <td
                    v-if="
                      score.subject_id > 2 &&
                      score.score >= 30 &&
                      score.score < 35
                    "
                    class="text-subtitle-1 text-warning"
                  >
                    D
                  </td>
                  <td
                    v-if="
                      score.subject_id > 2 &&
                      score.score >= 35 &&
                      score.score < 40
                    "
                    class="text-subtitle-1 text-warning"
                  >
                    C
                  </td>
                  <td
                    v-if="
                      score.subject_id > 2 &&
                      score.score >= 40 &&
                      score.score < 45
                    "
                    class="text-subtitle-1 text-green"
                  >
                    B
                  </td>
                  <td
                    v-if="
                      score.subject_id > 2 &&
                      score.score >= 45 &&
                      score.score < 50
                    "
                    class="text-subtitle-1 text-green"
                  >
                    A
                  </td>

                  <td v-if="score.score < 25" class="text-subtitle-1 text-red">
                    Failed
                  </td>
                  <td v-if="score.score>25" class="text-subtitle-1 text-green">Passed</td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
        <div class="total mb-5 mt-5 ms-4">
          <h4 class="mb-2">Total Score: {{ month.total }}</h4>
          <h4 class="mb-2">Average: {{ month.average }}</h4>
          <h4 class="mb-2">Grade: {{ month.grade }}</h4>
          <h4 class="mb-2">Status: {{ month.status }}</h4>
        </div>
      </v-window-item>
    </v-window>
  </v-card-text>
</template>

<script>
import http from "@/htpp.common";

export default {
  data: () => ({
    tab: null,
    user: [],
    scores: [],
    subjects: [],
    monthsWithAttendance: [
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
  }),
  computed: {
    scoresByMonth() {
      const scoresByMonth = {};
      for (const score of this.scores) {
        const month = new Date(score.month).getMonth() + 1;
        if (!scoresByMonth[month]) {
          scoresByMonth[month] = [];
        }
        scoresByMonth[month].push(score);
      }
      return scoresByMonth;
    },
    scoresByMonthWithSummary() {
      const scoresByMonth = {};
      for (const score of this.scores) {
        const month = new Date(score.month).getMonth() + 1;
        if (!scoresByMonth[month]) {
          scoresByMonth[month] = [];
        }
        scoresByMonth[month].push(score);
      }

      const scoresByMonthArray = Object.entries(scoresByMonth).map(
        ([month, scores]) => {
          const total = scores.reduce((acc, score) => acc + score.score, 0);
          const average = (total / (scores.length + 2)).toFixed(3);
          // const average = (total / 10).toFixed(3);
          const grade =
            average <= 25
              ? "F"
              : average <= 30
              ? "E"
              : average <= 35
              ? "D"
              : average <= 40
              ? "C"
              : average <= 47
              ? "B"
              : "A";
          const status = average <= 25 ? "Fail" : "Pass";
          return {
            month: parseInt(month),
            scores,
            total,
            average,
            grade,
            status,
          };
        }
      );

      return scoresByMonthArray.sort((a, b) => a.month - b.month);
    },
    displayTabs() {
      return this.scoresByMonthWithSummary.length > 0;
    },
  },
  methods: {
    getScore() {
      http.get("/v1/auth/user").then((response) => {
        this.scores = response.data.data.scores;
        console.log(response.data.data);
      });
    },
    getScoreByMonth(month) {
      return this.scores
        .filter((score) => {
          const scoreMonth = new Date(score.month).getMonth() + 1;
          return scoreMonth === month;
        })
        .map((score) => {
          const subject = this.subjects
            ? this.subjects.find((subject) => subject.id === score.subject_id)
            : null;
          return {
            ...score,
            subject_name: subject ? subject.subject_name : "Unknown Subject",
          };
        });
    },
  },
  mounted() {
    this.getScore();
  },
};
</script>

<style scoped>
@import "~vuetify/dist/vuetify.css";
.card {
  margin-left: 17%;
}
.table th {
  font-size: 20px;
}
.title {
  margin-left: 18%;
}
.thead {
  background: #004D40;
}
</style>
