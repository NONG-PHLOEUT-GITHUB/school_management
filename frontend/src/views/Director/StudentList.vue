<template>
  <div class="card shadow border-0 mb-7">
    <div class="card-header">
      <h3 class="mb-0 text-primary">STUDENTS LIST</h3>
    </div>
    <div class="card-header">
      <select
        class="form-select mb-3"
        aria-label="Default select example"
        style="width: 30%"
      >
        <option selected disabled>Select grade</option>
        <option value="10">Grade 10</option>
        <option value="11">Grade 11</option>
        <option value="12">Grade 12</option>
      </select>
      <div
        class="form-group d-flex justify-content-between mb-3"
        style="width: 100%"
      >
        <form class="form-inline my-2 my-lg-0 d-flex" style="width: 60%">
          <input
            class="form-control mr-sm-2"
            type="search"
            placeholder="Search student"
            aria-label="Search"
            style="width: 78%"
          />
          <button class="btn btn-outline-warning my-2 my-sm-0" type="button">
            <i class="bi bi-search"></i> Search
          </button>
        </form>
        <form
          class="input-file ms-4 me-3 border border-4 rounded-1 p-2"
          @submit.prevent="importFile"
        >
          <label for="file-input">Upload Excel file</label>
          <input type="file" ref="fileInput" id="file-input" />
          <i class="bi bi-cloud-arrow-up ms-2 mt-4"></i>
        </form>
        <router-link :to="{ path: '/createUser' }" class="text-white">
          <button type="button" class="btn btn-primary align-self-end ms-2">
            <i class="bi bi-person-plus-fill"></i> Add new student
          </button></router-link
        >
      </div>
    </div>
    <!-- get data form database to display -->
    <div class="card-header">
      <h5 class="mb-0 p-0 text-primary">STUDENT LIST CLASS 12A</h5>
    </div>
    <div class="table-responsive">
      <table class="table table-hover table-nowrap">
        <thead class="bg-primary">
          <tr>
            <th scope="col" class="fs-6 text-light">Name</th>
            <th scope="col" class="fs-6 text-light">Gender</th>
            <th scope="col" class="fs-6 text-light">Age</th>
            <th scope="col" class="fs-6 text-light">Email</th>
            <th scope="col" class="fs-6 text-light">Phone Number</th>
            <th scope="col" class="fs-6 text-light">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user, id) of listUser" :key="id" class="border-2-dark">
            <td>
              <img
                v-if="user.profile"
                :src="user.profile"
                class="avatar avatar-sm rounded-circle me-2"
              />
              <img
                v-else
                :src="user.profile"
                class="avatar avatar-sm rounded-circle me-2"
              />
              <a class="text-heading font-semibold" href="#">
                {{ user.first_name }} {{ user.last_name }}
              </a>
            </td>
            <td>
              {{ user.gender }}
            </td>
            <td>
              {{ user.age }}
            </td>
            <td>
              {{ user.email }}
            </td>
            <td>
              {{ user.phone_number }}
            </td>
            <td class="text-end d-flex justify-content-end">
              <router-link :to="{ path: '/student_detail/' + user.id }">
                <button
                  type="button"
                  class="btn btn-sm btn-neutral text-dark text-primary-hover bg-gray-300"
                >
                  <i class="bi bi-person-circle text-warning"></i> View Profile
                </button>
              </router-link>

              <router-link :to="{ path: '/edit/' + user.id }">
                <button
                  type="button"
                  class="btn btn-sm btn-neutral text-white text-dark-hover bg-warning ml-2"
                >
                  <i class="bi bi-pencil-square"></i> Edit
                </button>
              </router-link>

              <button
                type="button"
                class="btn btn-sm btn-neutral text-white text-dark-hover bg-danger ml-2"
                @click="deleteUser(user.id)"
              >
                <i class="bi bi-trash-fill"></i> Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import swal from "sweetalert";
import Swal from "sweetalert2";
import http from "../../htpp.common";
export default {
  data() {
    return {
      URL: "http://127.0.0.1:8000/api/users",
      listUser: [],
      errorMessage: "",
      searchQuery: "",
    };
  },

  computed: {
    filteredStudentsList() {
      if (this.searchQuery === "") {
        return this.listUser;
      } else {
        const filtered = this.listUser.filter((student) =>
          (student.first_name + " " + student.last_name)
            .toLowerCase()
            .includes(this.searchQuery.trim().toLowerCase())
        );
        if (filtered.length === 0) {
          return [
            {
              first_name: "Student not found",
              last_name: "",
              email: "",
              phone_number: "",
              etc: "",
            },
          ];
        } else {
          return filtered;
        }
      }
    },
  },
  methods: {
    //===================get data from Database =================
    getData() {
      axios.get(this.URL).then((response) => {
        this.listUser = response.data;
      });
    },
    //================== Delete a user =================
    deleteUser(id) {
      swal({
        title: "Are you sure?",
        text: "You will not be able to recover this user!",
        icon: "warning",
        buttons: ["Cancel", "Yes, delete it!"],
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          axios
            .delete(this.URL + `/${id}`)
            .then(() => {
              swal("Deleted!", "Your user has been deleted.", "success");
              // call mounted
              this.getData();
            })
            .catch((error) => {
              swal(
                "Error",
                "An error occurred while deleting the user.",
                "error"
              );
              console.error(error);
            });
        }
        // else {
        //   swal("Cancelled", "Your user is safe :)", "error");
        // }
      });
    },

    importFile() {
      /// progressbar
      let timerInterval;
      Swal.fire({
        title: "File Uploading",
        html: "Please wait for file upload <b></b> %.",
        timer: 2000, // Change the timer to 5000ms (5 seconds)
        timerProgressBar: true,
        didOpen: () => {
          Swal.showLoading();
          const b = Swal.getHtmlContainer().querySelector("b");
          let startTime = Date.now();
          timerInterval = setInterval(() => {
            let elapsedTime = Date.now() - startTime;
            let progress = Math.min(100, Math.round(elapsedTime / 20));
            b.textContent = progress;
          }, 20);
        },
        willClose: () => {
          clearInterval(timerInterval);
        },
      }).then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
          console.log("I was closed by the timer");
        }
      });
      /// data upload

      const file = this.$refs.fileInput.files[0];
      const formData = new FormData();
      formData.append("file", file);

      http
        .post("/users-import", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then(() => {
          /// progressbar
          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener("mouseenter", Swal.stopTimer);
              toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
          });

          Toast.fire({
            icon: "success",
            title: "Upload successful",
          });
          // call mounted
          this.getData();
                // Clear the file input
          this.$refs.fileInput.value = '';
        })
        .catch((error) => {
          console.error(error.response.data);
        });
    },
  },

  mounted() {
    this.$refs.fileInput.addEventListener("change", this.importFile);
    return this.getData();
  },
};
</script>

<style scoped>
.input-file {
  position: relative;
  overflow: hidden;
  width: 180px;
  border: none;
  background-color: #3590df;
  border-radius: 3px;
  box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.input-file:hover {
  background-color: #1d6f42;
}

.input-file [type="file"] {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  opacity: 0;
  cursor: pointer;
}

.input-file label {
  color: #f1f1f1;
  cursor: pointer;
  margin-top: 2px;
}

.input-file .bi {
  color: #e2d7d7;
}

.bi-brightness-low {
  color: yellow;
}
.bi-cloud-arrow-up {
  font-size: 20px;
  margin-top: 20px;
}
</style>
