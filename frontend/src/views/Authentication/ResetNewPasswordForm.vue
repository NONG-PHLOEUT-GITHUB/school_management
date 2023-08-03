<template>
  <div
    class="container d-flex align-center justify-center"
    style="height: 100vh"
  >
    <div class="ma-4">
      <h2>SCHOOL MANAGEMENT</h2>
      <v-img
        class="bg-white"
        width="300"
        :aspect-ratio="1"
        src="https://img.freepik.com/free-vector/key-concept-illustration_114360-6305.jpg?w=740&t=st=1688968989~exp=1688969589~hmac=3df727a833bf7fda300b7187397feb313d8ae5e060a5cec4ccf7c3f3e6872185"
        cover
      ></v-img>
    </div>
    <v-card
      width="500"
      class="mx-auto border--5 mx-auto pa-12 pb-8"
      elevation="10"
      max-width="448"
      rounded="lg"
    >
      <v-form ref="form" @submit.prevent="resetPassword">
        <h2 class="mb-4">Reset your password</h2>
        <div
          class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between"
        >
          New password
        </div>

        <v-text-field
          :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
          :type="visible ? 'text' : 'password'"
          density="compact"
          placeholder="Enter your new password"
          prepend-inner-icon="mdi-lock-outline"
          v-model="newPassword"
          :rules="passwordRules"
          variant="outlined"
          @click:append-inner="visible = !visible"
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
          :rules="confirmPasswordRule"
          variant="outlined"
          @click:append-inner="visibleConfirm = !visibleConfirm"
        >
        </v-text-field>

        <v-btn
          :disabled="!isPasswordValid"
          type="submit"
          color="teal-darken-4"
          block
          class="mt-4"
          >Reset Password</v-btn
        >
      </v-form>
    </v-card>
  </div>
</template>

<!-- // https://vee-validate.logaretm.com/v4/tutorials/basics/ -->
<script>
import Swal from "sweetalert2";
import Cookies from "js-cookie";
import http from "@/htpp.common";
export default {
  data() {
    return {
      dialog: false,
      visible: false,
      visibleConfirm: false,
      passwordShow: false,

      newPassword: "",
      confirmPassword: "",
      token: "",

      passwordRules: [
        (v) => !!v || "New password is required",
        (v) =>
          (v && v.length >= 8) || "Password must be 8  characters or more!",
      ],
      confirmPasswordRule: [
        (v) => !!v || "Confirm new password is required",
        (v) =>
          (v && v.length >= 8) || "Password must be 8  characters or more!",
      ],
    };
  },

  methods: {
    resetPassword() {
      const data = {
        password: this.newPassword,
        password_confirmation: this.confirmPassword,
        token: this.token,
      };
      http
        .post(`/reset-new-password/${this.token}`, data, {})
        .then((response) => {
          const ROLE = response.data.data.role;
          const token = response.data.access_token;
          if (ROLE === 1) {
            this.$router.push("/admin-dashboard");
          } else if (ROLE === 2) {
            this.$router.push("/teacher-dashboard");
          } else {
            this.$router.push("/student-dashboard");
          }

          // Set cookies
          Cookies.set("access_token", token, { expires: 14 });
          Cookies.set("user_role", ROLE, { expires: 14 });
          console.log("data", response.data.data.role);

          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 500,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener("mouseenter", Swal.stopTimer);
              toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
          });

          Toast.fire({
            icon: "success",
            title: "Your password has been reset successfully!",
            html: "<p>You can now login with your new password.</p>",
          }).then(() => {
            this.newPassword = "";
            this.confirmPassword = "";

            // this.$router.push('/login')
          });
        })

        .catch((error) => {
          if (error.response.status === 422) {
            // this.dialog = true;
            console.log(error.response.status);
            this.confirmPasswordRule = [
              "The password field confirmation does not match",
            ];
          } else {
            console.log("Unknown error occurred:", error);
          }
        });
    },
  },
  created() {
    this.token = this.$route.params.token;
  },
  computed: {
    isPasswordValid() {
      return this.newPassword.length >= 8;
    },
  },

  watch: {
    confirmPassword(value) {
      if (value !== this.newPassword) {
        this.confirmPasswordRule = ["The passwords do not match"];
      } else {
        this.confirmPasswordRule = [
          (v) => !!v || "Confirm new password is required",
          (v) =>
            (v && v.length >= 8) || "Password must be 8 characters or more!",
        ];
      }
    },
  },
};
</script>

<style scoped>
@import "~vuetify/dist/vuetify.css";

.alter {
  margin-bottom: 150%;
}
</style>
