<template>
  <admin-dashboard v-if="this.role === '1'"></admin-dashboard>
  <teacher-dashboard v-else-if="this.role === '2'"></teacher-dashboard>
  <student-dashboard v-else></student-dashboard>
  <v-sheet border="lg opacity-12" class="detail mt-6" elevation="4" height="auto" rounded max-width="80%">
    <v-container fluid>
      <v-row>
        <v-col cols="12" md="3" class="text-center">
          <v-img :src="users.profile" alt="Avatar" class="img-fluid my-7 w-75 rounded-circle ms-10" height="200" cover>
          </v-img>

          <input id="profilePictureInput" type="file" accept="image/*" class="d-none" @change="handleFileUpload">


          <div class="user">
            <h4 class="text-h5">
              {{ users.first_name }} {{ users.last_name }}
            </h4>
          </div>
        </v-col>

        <v-col cols="12" md="9">
          <v-col cols="auto" class="imformation">
            <v-btn block density="default  bg-teal-darken-4"><v-icon> mdi-information </v-icon>Personal Information
            </v-btn>

            <v-card variant="text" class="mt-4 text-subtitle-1">
              <v-icon class="me-2">mdi-account </v-icon>Full name :
              {{ users.first_name }} {{ users.last_name }}
            </v-card>

            <v-card variant="text mt-4" class="text-subtitle-1">
              <v-icon class="me-2"> mdi-gender-transgender </v-icon>Gender :
              {{ users.gender }}
            </v-card>
            <v-card variant="text mt-4">
              <v-icon class="me-2"> mdi-calendar </v-icon>Date of birth :
              {{ users.date_of_birth }}
            </v-card>
            <v-card variant="text mt-4" class="text-subtitle-1">
              <v-icon class="me-2"> mdi-numeric </v-icon>Age :
              {{ users.age }} years old
            </v-card>

            <v-btn block density="default mt-4 bg-teal-darken-4"><v-icon>mdi-map-marker</v-icon> Contact
              Information</v-btn>

            <v-card variant="text mt-4 " class="text-subtitle-1">
              <v-icon class="me-2"> mdi-phone </v-icon>Phone number :
              {{ users.phone_number }}
            </v-card>
            <v-card variant="text mt-4" class="text-subtitle-1">
              <v-icon class="me-2"> mdi-map-marker </v-icon>Address :
              {{ users.address }}
            </v-card>
            <v-card variant="text mt-4" class="text-subtitle-1">
              <v-icon class="me-2"> mdi-email </v-icon>Email : {{ users.email }}
            </v-card>
          </v-col>
          <v-col v-if="this.role != '1' && this.role != '2'" cols="auto">
            <v-btn block density="default  bg-teal-darken-4">
              <v-icon class="me-2"> mdi-account </v-icon>Parent
              Information</v-btn>
          </v-col>
          <div class="mt-4 ms-4">
              <v-card variant="text" class="mt-4">
                <v-icon class="me-2">mdi-account </v-icon>Full name :
                {{ guardian.first_name }} {{ guardian.last_name }}
              </v-card>
              <v-card variant="text" class="mt-4">
                <v-icon class="me-2">mdi-gender-transgender </v-icon>Gender :
                {{ guardian.gender }}
              </v-card>
              <v-card variant="text mt-4">
                <v-icon class="me-2"> mdi-phone </v-icon>Phone number :
                {{ guardian.phone_number }}
              </v-card>
              <v-card variant="text mt-4">
                <v-icon class="me-2"> mdi-map-marker </v-icon>Address :
                {{ guardian.address }}
              </v-card>
            </div>
        </v-col>
      </v-row>
    </v-container>
  </v-sheet>
</template>

<script>
import http from "@/htpp.common";
import Cookies from "js-cookie";
export default {
  name: "UserDetails",
  data() {
    return {
      users: " ",
      guardian: " ",
      role: "",
    };
  },
  methods: {
    fetchData() {
      http.get("/v1/auth/user").then((response) => {
        this.users = response.data.data;
        this.guardian = response.data.data.guardian;
      });
    },
    getRole() {
      let cookies = Cookies.get("user_role");
      this.role = cookies;
    },
  },



  mounted() {
    this.fetchData();
    this.getRole();
  },
};
</script>

<style scoped>
.detail {
  margin-left: 18%;
}

.imformation {
  display: flex;
  flex-direction: column;
}
</style>
