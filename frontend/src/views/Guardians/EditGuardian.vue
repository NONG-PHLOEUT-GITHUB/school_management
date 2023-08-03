<template>
  <admin-dashboard></admin-dashboard>
  <section class="container">
    <div class="card bg-gray-300">
      <div class="p-5 pb-1">
        <div>
          <h3 class="fs-19 fw-bold text-center">EDIT GUADIAN</h3>
        </div>
      </div>
      <form class="row g-3 card-body p-5 pt-4" @submit.prevent="editGuardian()">
        <!-- firstname -->
        <div class="col-md-6">
          <label for="validationCustom01" class="form-label">First name</label>
          <input
            type="text"
            v-model="listGuadian.first_name"
            class="form-control"
            id="validationCustom01"
          />
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="col-md-6">
          <label for="validationCustom02" class="form-label">Last name</label>
          <input
            type="text"
            v-model="listGuadian.last_name"
            class="form-control"
            id="validationCustom02"
          />
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="col-md-6">
          <label for="validationCustom02" class="form-label">Gender</label>
          <div class="gender">
            <input
              type="radio"
              name="gender"
              id="male"
              value="male"
              v-model="listGuadian.gender"
              class="form-check-input"
            />
            <label class="form-check-label" for="male">Male</label>
            <input
              type="radio"
              name="gender"
              id="female"
              value="female"
              v-model="listGuadian.gender"
              class="form-check-input ml-5"
            />
            <label class="form-check-label" for="female">Female</label>
          </div>
        </div>
        <div class="col-md-6">
          <label for="validationCustom02" class="form-label"
            >Chat id of guadian</label
          >
          <input
            type="text"
            v-model="listGuadian.chatId"
            class="form-control"
            id="validationCustom02"
          />
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="col-md-6">
          <label for="validationCustom02" class="form-label"
            >Phone Number</label
          >
          <input
            type="tel"
            v-model="listGuadian.phone_number"
            class="form-control"
            id="phoneNumber"
            placeholder=""
          />
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="col-md-6">
          <label for="validationCustom02" class="form-label">Address</label>
          <input
            type="tel"
            class="form-control"
            v-model="listGuadian.address"
            id="addreess"
            placeholder="   "
          />
          <div class="valid-feedback">Looks good!</div>
        </div>

        <div class="col-12 d-flex justify-content-end">
          <router-link
            type="submit"
            class="btn btn-warning text-white mr-2"
            :to="{ path: '/guardian-list' }"
            >Cancel</router-link
          >
          <button type="submit" class="btn btn-primary text-white">
            Edit Guardian
          </button>
        </div>
      </form>
    </div>
  </section>
</template>

<script>
import axios from "axios";
import swal from "sweetalert2";
export default {
  data() {
    return {
      listGuadian: [],
    };
  },
  mounted() {
    axios
      .get(`http://127.0.0.1:8000/api/Guardians/${this.$route.params.id}`)
      .then((response) => {
        this.listGuadian = response.data.data;
        console.log(this.listGuadian);
      });
  },
  methods: {
    editGuardian() {
      const newGuadian = {
        first_name: this.listGuadian.first_name,
        last_name: this.listGuadian.last_name,
        gender: this.listGuadian.gender,
        chatId: this.listGuadian.chatId,
        phone_number: this.listGuadian.phone_number,
        address: this.listGuadian.address,
      };
      axios
        .put(
          `http://127.0.0.1:8000/api/Guardians/${this.$route.params.id}`,
          newGuadian
        )
        .then((response) => {
          console.log(response);
          swal.fire({
            icon: "success",
            title: "Save guadian successfully!",
            text: "you already save guadian",
            timer: 2000,
          });
          this.$router.push({ path: "/guardian-list" });
        });
    },
  },
};
</script>

<style scoped>
.gender {
  background: #f8f7f7;
  padding: 10px;
  border-radius: 5px;
}

img {
  width: 100px;
}

.container {
  margin-left: 16%;
  width: 85%;
}
</style>
