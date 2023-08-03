<template>
  <admin-dashboard></admin-dashboard>
  <section class="container mt-4">
    <div class="card bg-gray-300">
      <div class="p-5 pb-1">
        <div>
          <h3 class="fs-19 fw-bold text-center">CREATE GUADIAN</h3>
        </div>
      </div>
      <form class="row g-3 card-body p-5 pt-4" @submit.prevent="addGuadian()">
        <!-- firstname -->
        <div class="col-md-6">
          <label for="validationCustom01" class="form-label">First name</label>
          <input type="text" v-model="first_name" class="form-control" id="validationCustom01" />
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="col-md-6">
          <label for="validationCustom02" class="form-label">Last name</label>
          <input type="text" v-model="last_name" class="form-control" id="validationCustom02" />
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="col-md-6">
          <label for="validationCustom02" class="form-label">Gender</label>
          <div class="gender">
            <input type="radio" name="gender" id="male" value="male" v-model="gender" class="form-check-input" />
            <label class="form-check-label" for="male">Male</label>
            <input type="radio" name="gender" id="female" value="female" v-model="gender" class="form-check-input ml-5" />
            <label class="form-check-label" for="female">Female</label>
          </div>
        </div>
        <div class="col-md-6">
          <label for="validationCustom02" class="form-label">Chat id of guadian</label>
          <input
            type="text"
            v-model="chatId"
            class="form-control"
            id="validationCustom02"
          />
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="col-md-6">
          <label for="validationCustom02" class="form-label">Phone Number</label>
          <input type="tel" v-model="phone_number" class="form-control" id="phoneNumber" placeholder="" />
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="col-md-6">
          <label for="validationCustom02" class="form-label">Address</label>
          <input type="tel" class="form-control" v-model="address" id="addreess" placeholder="   " />
          <div class="valid-feedback">Looks good!</div>
        </div>

        <div class="col-12 d-flex justify-content-end">
          <router-link type="submit" class="btn btn-warning text-white mr-2"
            :to="{ path: '/guardian-list' }">Cancel</router-link>
          <button type="submit" class="btn btn-primary text-white">
            Add Guardian
          </button>
        </div>
      </form>
    </div>
  </section>
</template>

<script>
import swal from "sweetalert2";
import http from "../../htpp.common";
export default {
  data() {
    return {
      first_name: "",
      last_name: "",
      gender: "",
      chatId: "",
      phone_number: "",
      address: "",
      listGuadian: [],
    };
  },
  methods: {
    addGuadian() {
      if (
        this.first_name &&
        this.last_name &&
        this.gender &&
        this.chatId &&
        this.phone_number &&
        this.address
      ) {
        const newGuadian = {
          first_name: this.first_name,
          last_name: this.last_name,
          gender: this.gender,
          chatId: this.chatId,
          phone_number: this.phone_number,
          address: this.address,
        };
        http.post('/Guardians', newGuadian).then((response) => {
            this.listGuadian.push(response.data.data);
            console.log(this.listGuadian);
        });
        swal
          .fire({
            icon: "success",
            title: "Save guardian successfully!",
            text: "you already save the guardian",
            timer: 2000,
          })
          .then(() => {
            this.$router.push({ path: "/guardian-list" });
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        swal.fire("Complete first", "complete all input", "info");
      }
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
