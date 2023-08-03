<template>
  <admin-dashboard></admin-dashboard>
  <div class="main">
    <h3 class="mb-0 text-teal-darken-4 mt-4">CLASSES LIST</h3>
    <v-card class="card d-flex mt-5 pa-5">
      <v-btn color="teal-darken-4 w-25 mb-4" class="mt-4 ms-5" @click="dialog = true"><v-icon>mdi-plus-outline</v-icon>
        add new
        class</v-btn>
      <v-row justify="center">
        <v-dialog v-model="dialog" persistent width="40%">
          <v-card>
            <v-form @submit.prevent="saveClassroom">
              <v-card-title>
                <span class="text-h5">{{ formAction }}</span>
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12">
                      <v-text-field v-model="className" label="Class name" required variant="outlined"></v-text-field>
                    </v-col>
                    <v-col cols="12">
                      <label for="" class="mb-4">Pleas chose teacher</label>
                      <select v-model="selectedTeacher" class="form-select" aria-label="Default select example">
                        <option v-for="teacher in teacherList" :key="teacher.id" :value="teacher.id">
                          {{ teacher.first_name }} {{ teacher.last_name }}
                        </option>
                      </select>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue-darken-1" variant="text" @click="dialog = false">Cancel</v-btn>
                <v-btn type="submit" color="blue-darken-1">Save</v-btn>
              </v-card-actions>
            </v-form>
          </v-card>
        </v-dialog>
      </v-row>
    </v-card>

    <v-card v-for="classroom in classrooms" :key="classroom.id" class="card mx-auto mt-2" width="96%"
      prepend-icon="mdi-home" elevation="4">
      <template v-slot:title> Class : {{ classroom.class_name }} </template>

      <div class="action">
        <v-col cols="auto">
          <v-btn color="teal-darken-4" :to="{ path: '/student-score-report/' + classroom.id }" class="me-4">
            <v-icon>mdi-chart-line</v-icon> Score report
          </v-btn>
          <v-btn color="teal-darken-4" :to="{ path: '/attendance_list/' + classroom.id }">
            <v-icon>mdi-calendar-clock</v-icon> Attendance report
          </v-btn>
          <v-btn color="teal-darken-4" :to="{ path: '/feedback/' + classroom.id }" class="ms-4">
            <v-icon>mdi-poll</v-icon> Studen feedback
          </v-btn>
        </v-col>
        <v-col class="manage">
          <v-btn @click="editClassroom(classroom)" color="green" class="me-2">
            <v-icon>mdi-pencil</v-icon>Edit
          </v-btn>
          <v-btn @click="deleteClassroom(classroom.id)" color="red" class="text-white">
            <v-icon>mdi-delete</v-icon> Delete 
          </v-btn>
        </v-col>
      </div>

    </v-card>
  </div>
</template>

<script>
import http from "@/htpp.common";
import Swal from "sweetalert2";
export default {
  data() {
    return {
      selectedClass: "",
      dialog: false,
      teachers: [],
      selectedTeacher: null,
      classrooms: [],
      teacherList: [],
      className: "",
      formAction: "Add Classroom",
      editing: false,
      editId: null,
      listClass: [],
    };
  },

  computed: {
    fullName() {
      return `${this.first_name} ${this.last_name}`;
    },
  },

  methods: {
    showStudents(classId) {
      http
        .get(`/getuserInClass/${classId}`)
        .then((response) => {
          console.log(classId);
          this.listUser = response;
        })
        .catch((error) => {
          this.listUser = [];
          console.log(error.response.data.error);
        });
    },

    // ...

    addTeacher() {
      // Send a POST request to create a new classroom
      http
        .post("/classrooms", {
          class_name: this.className,
          teacher_id: this.selectedTeacher,
        })
        .then((response) => {
          console.log("New classroom created:", response.data);
          // Reset the form fields
          this.className = null;
          this.selectedTeacher = null;
          // Reload the list of classrooms
          this.fetchClassrooms();
          // Show a success message using sweetalert2
        })
        .catch((error) => {
          console.log("Error creating classroom:", error);
          // Show an error message using sweetalert2
        });
    },
    getTeacher() {
      http.get("/get-teachers").then((response) => {
        this.teacherList = response.data.data;
      });
    },
    onTeacherSelected(teacher) {
      // this.selectedTeacher = teacher.text;
      this.selectedTeacher = teacher.value;
    },

    fetchClassrooms() {
      http.get("/classrooms").then((response) => {
        this.classrooms = response.data.data;
        console.log("class", this.classrooms);
      });
    },

    saveClassroom() {
      const newclassroom = {
        class_name: this.className,
        user_id: this.selectedTeacher,
      };

      if (this.editing) {
        http
          .put(`/classrooms/${this.editId}`, newclassroom)
          .then(() => {
            this.cancelForm();
            this.fetchClassrooms();
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        http
          .post("/classrooms", newclassroom)
          .then(() => {
            this.cancelForm();
            this.fetchClassrooms();
            Swal.fire({
              title: "Teacher added",
              icon: "success",
              timer: 3000,
            });
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },

    editClassroom(classroom) {
      this.formAction = "Edit Classroom";
      this.editing = true;
      this.editId = classroom.id;
      this.className = classroom.class_name;
      this.selectedTeacher = classroom.teacher_id;
      this.dialog = true;
    },

    updateClassroom() {
      const id = this.editId;
      // Send a PUT request to update the classroom
      http
        .put(`/classrooms/${id}`, {
          class_name: this.className,
          teacher_id: this.selectedTeacher,
        })
        .then((response) => {
          this.fetchClassrooms();
          console.log("Classroom updated:", response.data);
          this.className = null;
          this.selectedTeacher = null;
          // Reload the list of classrooms
          this.dialog = false;
        })
        .catch((error) => {
          console.log("Error updating classroom:", error);
        });
    },

    cancelForm() {
      this.formAction = "Add Classroom";
      this.editing = false;
      this.editId = null;
      this.classroom = { className: "", teacher: "" };
      this.selectedTeacher = null;
      this.dialog = false;
    },

    // ...

    deleteClassroom(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You will not be able to recover this classroom!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
      }).then((result) => {
        if (result.isConfirmed) {
          http
            .delete(`/classrooms/${id}`)
            .then(() => {
              const index = this.classrooms.findIndex((c) => c.id === id);
              if (index !== -1) {
                this.classrooms.splice(index, 1);
              }
              Swal.fire({
                title: "Deleted!",
                text: "The classroom has been deleted.",
                icon: "success",
              });
            })
            .catch((error) => {
              console.log(error);
            });
        }
      });
    },
    getStudentInClass() {
      http
        .get(`/get-students`)
        .then((response) => {
          response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },

  mounted() {
    this.getStudentInClass();
    this.fetchClassrooms();
    this.getTeacher();
  },
};
</script>
<style scoped>
@import "~vuetify/dist/vuetify.css";

.main {
  margin-left: 18%;
  margin-top: 15px;
}

.action {
  display: flex;
}

.manage {
  display: flex;
  justify-content: flex-end;
}

.card {
  border-left: solid 5px #004D40;
}
</style>
