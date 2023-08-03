<template>
  <v-layout class="rounded rounded-md">
    <v-navigation-drawer class="sibar">
      <v-list>
        <v-list-item class="drawer">
          <v-list-item>
            <div class="image">
              <v-img
                class="image"
                src="https://www.ayushmatrimony.com/Services/assets/images/SMSLogo.png"
                rounded
                rounded-sm
              >
              </v-img>
            </div>
          </v-list-item>
          <v-list-item class="mt-10">
            <v-btn
              v-for="menu in menubar"
              :key="menu"
              class="btn mt-4"
              block
              rounded
              variant="outlined"
              :to="menu.path"
              active-class="white--text"
            >
              <v-icon size="24" class="me-2">
                {{ menu.icon }}
              </v-icon>
              {{ menu.title }}
            </v-btn>
          </v-list-item>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar title="School Management">
      <v-menu offset-y open-on-hover>
        <template v-slot:activator="{ props }">
          <v-btn>{{ users.first_name }} {{ users.last_name }}</v-btn>
          <v-btn icon v-bind="props">
            <v-avatar color="brown" size="large">
              <v-img :src="users.profile" alt="Avatar" cover> </v-img>
            </v-avatar>
          </v-btn>
        </template>

        <v-card>
          <div class="mx-auto text-center mt-4">
            <v-avatar size="100" color="" class="avatar">
              <v-img class="image" :src="users.profile" alt="Avatar" cover>
              </v-img>
            </v-avatar>
            <h4 class="user-name mt-3">
              {{ users.first_name }} {{ users.last_name }}
            </h4>
            <p class="text-caption mt-1">
              {{ users.email }}
            </p>
          </div>
          <v-card-text>
            <div class="mx-auto text-center">
              <v-btn
                size="small"
                class="btn mt-2"
                block
                variant="outlined"
                rounded
                to="/user-profile"
                active-class="white--text"
              >
                <v-icon> mdi-account </v-icon>Profile
              </v-btn>

              <v-btn
                size="small"
                @click="dialogVisible = true"
                class="btn mt-2"
                block
                variant="outlined"
                rounded
                active-class="white--text"
              >
                <v-icon> mdi-lock </v-icon>
                Change Password
              </v-btn>
              <v-btn
                @click="logout"
                size="small"
                class="btn mt-2"
                block
                variant="outlined"
                rounded
                active-class="white--text"
              >
                <v-icon> mdi-logout </v-icon>
                Logout
              </v-btn>
            </div>
          </v-card-text>
        </v-card>
      </v-menu>
    </v-app-bar>

    <v-main class="main">
      <router-view></router-view>
    </v-main>
  </v-layout>

  <v-dialog
    v-model="dialogVisible"
    transition="dialog-top-transition"
    width="auto"
  >
    <change-password-dialog
      @cancel="dialogVisible = false"
      @password-changed="dialogVisible = false"
    />
  </v-dialog>
</template>

<script>
// https://snyk.io/advisor/npm-package/lru-cache/functions/lru-cache
import http from "@/htpp.common";
import Cookies from "js-cookie";
import Swal from "sweetalert2";
import ChangePasswordDialog from "@/views/Authentication/ChangePasswordForm.vue";
import LRU from "lru-cache";
const cache = new LRU(100);

export default {
  props: ["menubar"],
  name: "LayoutDashboard",

  components: {
    ChangePasswordDialog,
  },
  data: () => ({
    users: [],
    dialogVisible: false,
  }),

  methods: {
    async fetchData() {
      const cachedResponse = cache.get("users");

      if (cachedResponse) {
        this.users = cachedResponse;
        return;
      }

      try {
        const response = await http.get("/v1/auth/user");
        this.users = response.data.data;
        cache.set("users", this.users);
      } catch (error) {
        console.error(error);
      }
    },

    logout() {
      http
        .post(
          "/v1/auth/logout",
          {},
          {
            headers: {
              Authorization: "Bearer " + Cookies.get("access_token"),
            },
          }
        )
        .then(() => {
          Swal.fire({
            title: "Are you sure you want to logout?",
            // text: "You won't be able to revert this!",
            showCancelButton: true,
            position: "top-end",
            customClass: {
              confirmButton: "confirm-button-class",
              title: "title-class",
              icon: "icon-class",
            },
          }).then((result) => {
            if (result.isConfirmed) {
              const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 500,
                timerProgressBar: true,
              });
              Toast.fire({
                icon: "success",
                title: "You have been logged out",
              });
              Cookies.remove("access_token");
              Cookies.remove("user_role");
              this.$router.push("/login");
            }
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    this.fetchData();
  },
};
</script>

<style scoped>
@import "~vuetify/dist/vuetify.css";

.white--text {
  color: white !important;
}

.sibar {
  margin-right: 20px;
  box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px,
    rgba(0, 0, 0, 0.3) 0px 30px 60px -30px;
}

.btn {
  display: flex;
  justify-content: flex-start;
  border: solid 1px gray;
  font-size: 12px;
}

.image {
  margin-top: 10%;
}
.user-name span {
  text-transform: uppercase;
}

.user-name {
  text-transform: uppercase;
}

.title-class {
  font-size: 15px !important;
}
</style>
