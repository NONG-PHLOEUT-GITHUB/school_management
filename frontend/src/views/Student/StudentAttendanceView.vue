<template>
  <student-dashboard></student-dashboard>
  <div>
    <h3 class="text">ABSENCE MONTHLY RECORD</h3>
    <v-card class="card mt-3">
      <v-tabs v-model="tab" class="tab">
        <v-tab v-for="(month, index) in months" :key="index" :value="index + 1">
          {{ month }}
        </v-tab>
      </v-tabs>
      <v-card-text class="container">
        <v-window v-model="tab">
          <v-window-item v-for="(month, index) in months" :key="index" :value="index + 1">
            <div class="table-responsive">
              <table class="table table-hover table-nowrap">
                <thead>
                  <tr class="thead">
                    <th scope="col">Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Reason</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(detail, index) in filteredAttendanceDetails" :key="index">
                    <td class="text-subtitle-1">{{ detail.date }}</td>
                    <td class="text-subtitle-1">
                      {{ detail.status }}
                    </td>
                    <td class="text-subtitle-1">{{ detail.reason }}</td>
                  </tr>
                  <tr v-if="filteredAttendanceDetails.length === 0">
                    <td colspan="5" class="text-center text-lg text-red ">
                      No absence records for this month.
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </v-window-item>
        </v-window>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import http from "@/htpp.common.js";
export default {
  data() {
    return {
      tab: 1,
      months: [
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
      attendanceDetails: [],
    };
  },
  computed: {
    filteredAttendanceDetails() {
      return this.attendanceDetails.filter((detail) => {
        if (detail.date) {
          return parseInt(detail.date.split("-")[1]) === this.tab;
        }
        return false;
      });
    },
  },

  methods: {
    getAttendanceDetails() {
      http
        .get("/v1/auth/user")
        .then((response) => {
          this.attendanceDetails = response.data.data.attendances;
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },

  mounted() {
    this.getAttendanceDetails();
  },
};
</script>

<style scoped>
.card {
  margin-left: 17%;
}

.text {
  margin-left: 47%;
  padding: 1%;
}

.container {
  padding: 5px;
}

.table th {
  font-size: 15px;
}

.tab{
  color: white;
  background: #004D40;
}
.thead{
  background: #004D40;
}
.thead th {
  
  color: white;
}
</style>
