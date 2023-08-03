<template>
  <admin-dashboard></admin-dashboard>
  <section class="container mt-4">
    <div class="card bg-gray-300">
      <div class="p-5 pb-1">
        <div>
          <h3 class="fs-19 fw-bold text-center">EDIT USER</h3>
        </div>
      </div>
      <form class="row g-3 card-body p-5 pt-4" @submit.prevent="submitForm">
        <!-- firstname -->
        <div class="col-md-6">
          <label for="validationCustom01" class="form-label">First name</label>
          <input type="text" v-model="user.first_name" class="form-control" id="validationCustom01" />
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="col-md-6">
          <label for="validationCustom02" class="form-label">Last name</label>
          <input type="text" v-model="user.last_name" class="form-control" id="validationCustom02" />
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="col-md-6">
          <label for="validationCustom02" class="form-label">Email</label>
          <input type="text" v-model="user.email" class="form-control" id="validationCustom02" />
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="col-md-6">
          <label for="validationCustom02" class="form-label">Password</label>
          <input type="password" v-model="user.password" class="form-control" id="validationCustom02" />
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="col-md-6">
          <label for="validationCustom02" class="form-label">Phone Number</label>
          <input type="tel" v-model="user.phone_number" class="form-control" id="phoneNumber" placeholder="" />
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="col-md-6">
          <label for="validationCustom02" class="form-label">Address</label>
          <input type="tel" class="form-control" v-model="user.address" id="addreess" placeholder="   " />
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="col-md-6">
          <label for="validationCustom02" class="form-label">Date of Birth</label>
          <input type="date" class="form-control" v-model="user.date_of_birth" :max="max_date" id="dateOfBirth"
            placeholder="" />
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="col-md-6">
          <label for="validationCustom02" class="form-label">Age</label>
          <input type="number" class="form-control" id="dateOfBirth" v-model="updatedAge" placeholder="" />
          <div class="valid-feedback">Looks good!</div>
        </div>

        <div class="col-md-6">
          <label for="validationCustom02" class="form-label">Gender</label>
          <div class="gender">
            <input type="radio" name="gender" id="male" value="male" v-model="user.gender" class="form-check-input" />
            <label class="form-check-label" for="male">Male</label>
            <input type="radio" name="gender" id="female" value="female" v-model="user.gender"
              class="form-check-input ml-5" />
            <label class="form-check-label" for="female">Female</label>
          </div>
        </div>

        <div class="mb-3 col-md-6">
          <label for="formFileDisabled" class="form-label">Profile</label>
          <input class="form-control" type="file" id="formFileDisabled" @change="getImage" />
        </div>
        <div class="mb-3 col-md-6">
          <label for="formFileDisabled" class="form-label">Class</label>
          <select
            v-model="user.class_room_id"
            class="form-select"
            aria-label="Default select example"
          >
            <option
              v-for="classroom in classrooms"
              :key="classroom"
              :value="classroom.id"
            >
              {{ classroom.class_name}}
            </option>
          </select>
        </div>
        <div class="mb-3 col-md-6">
          <label for="formFileDisabled" class="form-label">Guardian</label>
          <select
            v-model="user.guardian_id"
            class="form-select"
            aria-label="Default select example"
          >
            <option
              v-for="guardian in guardians"
              :key="guardian"
              :value="guardian.id"
            >
             <strong>{{ guardian.first_name}}  {{ guardian.last_name}}</strong> 
            </option>
          </select>
        </div>

        <div class="col-12 d-flex justify-content-end">
          <router-link class="btn btn-warning text-white mr-2" :to="{ path: '/student-list' }">Cancel</router-link>
          <button type="submit" class="btn btn-primary text-white">
            Update User
          </button>
        </div>
      </form>
    </div>
  </section>
</template>

<script>
import swal from "sweetalert2";
import http from "../../htpp.common";
import axios from "axios";

export default {
  data() {
    return {
      user: {},
      isUpate: true,
      image: null,
      profile: {},
      updatedAge: null,
      guardians: [],
      classrooms: [],
    };
  },
  mounted() {
    http.get(`/users/${this.$route.params.id}`).then((response) => {
      this.user = response.data.data;
      this.calculateAge(); // Call calculateAge method on mount to set the initial value of updatedAge
      this.getGuardian();
      this.getClassRoom();
    });
  },
  methods: {
    getImage(event) {
      var file = event.target.files[0];
      var form = new FormData();
      form.append("profile", file);
      axios
        .post("http://127.0.0.1:8000/api/getImage", form)
        .then((response) => {
          this.profile = response.data;
        });
    },
    submitForm() {
      const newData = {
        first_name: this.user.first_name,
        last_name: this.user.last_name,
        email: this.user.email,
        password: this.user.password,
        phone_number: this.user.phone_number,
        address: this.user.address,
        date_of_birth: this.user.date_of_birth,
        age: this.updatedAge,
        gender: this.user.gender,
        profile: this.profile,
      };

      http
        .put(`/users/${this.$route.params.id}`, newData)
        .then((response) => {
          console.log(response);
          swal.fire({
            icon: "success",
            title: "Success!",
            text: "User updated successfully",
            timer: 2000,
          });
        })
        .then(() => {
          this.$router.push({ path: "/student-list" });
        })
        .catch((error) => {
          console.error("User update failed:", error);
        });
    },
    calculateAge() {
      const dob = new Date(this.user.date_of_birth);
      const today = new Date();
      let age = today.getFullYear() - dob.getFullYear();
      const monthDiff = today.getMonth() - dob.getMonth();
      if (
        monthDiff < 0 ||
        (monthDiff === 0 && today.getDate() < dob.getDate())
      ) {
        age--;
      }
      this.updatedAge = age;
    },
    // get class room for create
    getClassRoom() {
      http.get("/classrooms").then((response) => {
        this.classrooms = response.data.data;
      });
    },
    // get guardian for create
    getGuardian() {
      http.get('/getGuardians')
      .then((response) => {
        this.guardians = response.data.data;
        console.log(this.guardians);
      });
    },
  },

  watch: {
    "user.date_of_birth": function () {
      this.calculateAge();
      this.user.date_of_birth = new Date(
        new Date().getFullYear() - this.updatedAge,
        new Date().getMonth(),
        new Date().getDate()
      )
        .toISOString()
        .substr(0, 10);
    },
  },
};
</script>

<style scoped>
.gender {
  background: #f8f7f7;
  padding: 10px;
  border-radius: 5px;
  width: 100%;
}
.container {
  margin-left: 16%;
  width: 85%;
}
</style>
