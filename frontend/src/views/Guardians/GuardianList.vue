<template>
    <admin-dashboard></admin-dashboard>
    <div class="card shadow border-0 mb-7 mt-4 elevation-4" >
    <div class="card-header">
      <h2 class="mb-0 text-teal ">Guadian List</h2>
    </div>
    <div class="card-header">
      <div
        class="form-group d-flex justify-content-between mb-3"
        style="width: 100%"
      >
        <form class="form-inline my-2 my-lg-0 d-flex" style="width: 60%">
          <input
            class="form-control mr-sm-2"
            type="search"
            placeholder="Search user"
            aria-label="Search"
            v-model="searchQuery"
            style="width: 78%"
          />
          <button class="btn btn-outline-warning my-2 my-sm-0" type="button">
            <i class="bi bi-search"></i> Search
          </button>
        </form>
          <v-btn to="/add-guadian" color="teal-darken-4"> Add new guardian <v-icon>mdi-plus-outline</v-icon></v-btn>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-hover table-nowrap">
        <thead class="thead">
          <tr>
            <th scope="col" class="fs-6 text-light">Name</th>
            <th scope="col" class="fs-6 text-light">Gender</th>
            <th scope="col" class="fs-6 text-light">Chatid</th>
            <th scope="col" class="fs-6 text-light">Phone Number</th>
            <th scope="col" class="fs-6 text-light">Address</th>
            <th scope="col" class="fs-6 text-light">Action</th>
          </tr>
        </thead>

        <tbody v-if="listGuardian && listGuardian.length">
          <tr
            v-for="(gardian, id) of SearchGaurdian"
            :key="id"
            class="border-2-dark"
          >
            <td class="text-subtitle-1">{{ gardian.first_name }} {{ gardian.last_name }}</td>
            <td class="text-subtitle-1">
              {{ gardian.gender }}
            </td>
            <td class="text-subtitle-1">
              {{ gardian.chatId }}
            </td>
            <td class="text-subtitle-1">
              {{ gardian.phone_number }}
            </td>
            <td class="text-subtitle-1">
              {{ gardian.address }}
            </td>
            <td class="text-end d-flex justify-content-start">
              <router-link :to="{ path: '/edit-guadian/' + gardian.id }">
                <button
                  type="button"
                  class="btn btn-sm btn-neutral text-white text-dark-hover bg-warning ml-2"
                >
                  <i class="bi bi-pencil-square"></i> Edit
                </button>
              </router-link>

              <button type="button" class="btn btn-sm btn-neutral text-white text-dark-hover bg-red ml-2"
                @click="deleteUser(gardian.id)">
                <i class="bi bi-trash-fill"></i> Delete
              </button>
            </td>
          </tr>
        </tbody>
        <tr v-else>
          <td colspan="6" class="text-center text-danger">
            This class does not have any user.
          </td>
        </tr>
      </table>
      <div class="card-footer border-0 py-5">
        <span class="text-muted text-subtitle-1">
          Total guadian :
          {{ listGuardian?.length }} people</span
        >
      </div>
    </div>
  </div>
</template>

<script>
import swal from "sweetalert";
import http from "../../htpp.common";

export default {
  data() {
    return {
      listGuardian: [],
      searchQuery: "",
    };
  },
  computed: {
    SearchGaurdian() {
      if (this.searchQuery === "") {
        return this.listGuardian;
      } else {
        const filtered = this.listGuardian.filter((guardian) =>
          (guardian.first_name + " " + guardian.last_name)
            .toLowerCase()
            .includes(this.searchQuery.trim().toLowerCase())
        );
        return filtered;
      }
    },
  },
  methods: {
    getGuardian() {
      http.get("/getGuardians").then((response) => {
        this.listGuardian = response.data.data;
      });
    },
    deleteUser(id) {
      swal({
        title: "Are you sure?",
        text: "You will not be able to recover this guardian!",
        icon: "warning",
        buttons: ["Cancel", "Yes, delete it!"],
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          http
            .delete("/Guardians" + `/${id}`)
            .then(() => {
              swal("Deleted!", "The guardian has been deleted.", "success");
              // call mounted
              this.getGuardian();
            })
            .catch((error) => {
              swal(
                "Error",
                "An error occurred while deleting the guardian.",
                "error"
              );
              console.error(error);
            });
        } else {
          swal("Cancelled", "Your guardian is safe :)", "error");
        }
      });
    },
  },
  mounted() {
    this.getGuardian();
  },
};
</script>

<style scoped>
.card {
  margin-left: 18%;
  margin-right: 10px;
}
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

.card {
  padding: 20px;
}

.thead{
  background: #004D40;
}
</style>
