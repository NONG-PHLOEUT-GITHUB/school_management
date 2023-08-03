<template>
  <v-snackbar
    class="snackbar"
    v-model="snackbarVisible"
    :timeout="10000"
    color="success"
  >
    Your password has been changed successfully!
  </v-snackbar>
  <div
    class="container d-flex align-center justify-center"
    style="height: 100vh"
  >
    <v-card
      width="500"
      class="mx-auto border--5 mx-auto pa-12 pb-8"
      elevation="10"
      max-width="448"
      rounded="lg"
    >
      <v-form ref="form" @submit.prevent="changePassword">
        <v-title>
          <h1>Change password</h1>
        </v-title>
        <div class="text-subtitle-1 text-medium-emphasis mt-8">
          Current password
        </div>

        <v-text-field
          :append-inner-icon="visibleCurrent ? 'mdi-eye-off' : 'mdi-eye'"
          :type="visibleCurrent ? 'text' : 'password'"
          density="compact"
          placeholder="Enter current password"
          prepend-inner-icon="mdi-lock-outline"
          v-model="currentPassword"
          :rules="newPasswordRole"
          variant="outlined"
          @click:append-inner="visibleCurrent = !visibleCurrent"
        >
        </v-text-field>
        <span :rules="currentPasswordRole"></span>

        <div
          class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between"
        >
          New password
        </div>

        <v-text-field
          :append-inner-icon="visibleNew ? 'mdi-eye-off' : 'mdi-eye'"
          :type="visibleNew ? 'text' : 'password'"
          density="compact"
          placeholder="Enter your new password"
          prepend-inner-icon="mdi-lock-outline"
          v-model="newPassword"
          :rules="newPasswordRole"
          variant="outlined"
          @click:append-inner="visibleNew = !visibleNew"
        >
        </v-text-field>

        <div
          class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between"
        >
          Confirm new password
        </div>
        <v-text-field
          :append-inner-icon="visibleConfirm ? 'mdi-eye-off' : 'mdi-eye'"
          :type="visibleConfirm ? 'text' : 'password'"
          density="compact"
          placeholder="Enter your confirm new password"
          prepend-inner-icon="mdi-lock-outline"
          v-model="confirmPassword"
          :rules="confirmPasswordRoles"
          variant="outlined"
          @click:append-inner="visibleConfirm = !visibleConfirm"
        >
        </v-text-field>

        <v-row no-gutters>
          <v-col>
            <v-btn
              @Click="cancel"
              class="mt-4 w-25"
              color="teal-darken-4"
              block
              variant="outlined"
              >Cancel</v-btn
            >
          </v-col>
          <v-col>
            <v-btn type="submit" color="teal-darken-4" block class="mt-4 ms-1"
              >Save</v-btn
            >
          </v-col>
        </v-row>
      </v-form>
    </v-card>
  </div>
</template>

<!-- https://vee-validate.logaretm.com/v4/tutorials/basics/ -->
<script>
import http from "../../htpp.common";
export default {
  emits: ["cancel", "password-changed"],
  data() {
    return {
      snackbarVisible: false,
      visibleCurrent: false,
      visibleNew: false,
      visibleConfirm: false,

      currentPassword: "",
      newPassword: "",
      confirmPassword: "",

      currentPasswordRole: [
        (v) => !!v || "Current password is required",
        (v) =>
          (v && v.length >= 8) || "Password must be 8  characters or more!",
      ],
      newPasswordRole: [
        (v) => !!v || "New password is required",
        (v) =>
          (v && v.length >= 8) || "Password must be 8  characters or more!",
      ],
      confirmPasswordRoles: [
        (v) => !!v || "Confirm new password is required",
        (v) =>
          (v && v.length >= 8) || "Password must be 8  characters or more!",
        (v) => v === this.newPassword || "Passwords do not match",
      ],
    };
  },
  methods: {
    changePassword() {
      if (this.newPassword !== this.confirmPassword) {
        this.confirmPasswordRoles = ["Confirm password does not match"];
        return;
      }

      const data = {
        current_password: this.currentPassword,
        new_password: this.newPassword,
        new_password_confirmation: this.confirmPassword,
      };

      http
        .post("/password/change", data, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("access_token")}`,
          },
        })
        .then(() => {
          this.snackbarVisible = true;
          setTimeout(() => {
            this.currentPassword = "";
            this.newPassword = "";
            this.confirmPassword = "";
            this.$emit("password-changed");
          }, 1000);
        })
        // .then(() => {
        // })
        .catch((error) => {
          if (
            error.response &&
            error.response.status === 400 &&
            error.response.data.error === "Current password is incorrect"
          ) {
            this.currentPasswordRole = [
              "The current password you entered is incorrect. Please try again.",
            ];
          } else if (error.response && error.response.status === 400) {
            const errorData = error.response.data;
            if (errorData.error && errorData.error.current_password) {
              this.currentPasswordRole = [errorData.error.current_password[0]];
            } else if (errorData.error && errorData.error.new_password) {
              this.newPasswordRole = [errorData.error.new_password[0]];
            } else {
              // Handle other validation errors
              console.log(errorData);
            }
          } else if (error.response && error.response.status === 404) {
            const errorData = error.response.data;
            if (errorData.error === "User not found") {
              this.currentPasswordRole = ["User not found. Please try again."];
            } else {
              // Handle other errors
              console.log(errorData);
            }
          } else {
            console.log(error);
          }
        });
    },
    cancel() {
      this.$emit("cancel");
    },
  },
};
</script>

<style scoped>
.snackbar {
  margin-bottom: 38%;
}
</style>
