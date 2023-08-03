<template>
  <admin-dashboard v-if="this.role === '1'"></admin-dashboard>
  <teacher-dashboard v-else-if="this.role === '2'"></teacher-dashboard>
  <div class="give-feedback-container mt-5">
    <h2>Give Feedback</h2>
    <form @submit.prevent="giveComment">
      <div class="form-group">
        <label for="student-name">Student</label>
        <div class="select-container">
          <select
            v-model="selectedStudent"
            class="form-select"
            aria-label="Default select example"
          >
            <option
              v-for="student in listUser"
              :key="student.id"
              :value="student.id"
            >
              {{ student.first_name }} {{ student.last_name }}
            </option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="feedback-text">Feedback</label>
        <textarea
          id="feedback-text"
          name="feedback-text"
          rows=""
          required
          v-model="comment"
        ></textarea>
      </div>
      <v-btn type="submit" color="teal-darken-4">Submit</v-btn>
    </form>
  </div>
</template>

<script>
import Swal from "sweetalert2";
import http from "@/htpp.common";
import Cookies from "js-cookie";
export default {
  data() {
    return {
      listUser: [],
      selectedStudent: null,
      comment: "",
      teacher_id: null,
      role:"",
      teachers:[],
    };
  },
  methods: {
    getData() {
      http.get("/get-students").then((response) => {
        this.listUser = response.data;
        console.log(this.listUser);
      });
    },
    giveComment() {
      const commentData = {
        body: this.comment,
        user_id: this.selectedStudent,
        teacher_id: this.teacherID,
      };
      http.post("/comments", commentData).then((response) => {
        console.log(response);
      });
      Swal.fire({
        icon: "success",
        title: "Message sent successfully!",
        text: "Your Comment successfully to student",
        timer: 2000,
      });
      this.selectedStudent = null;
      this.comment = "";
    },
    fetchTeacherData() {
      http.get("/v1/auth/user").then((response) => {
        // this.teachers = response.data.data.id;
        // console.log(this.teachers);
        this.teacherID = response.data.data.id;
      });
    },
    getTeacherId() {
      http.get("/get-students").then((response) => {
        this.listUser = response.data.data;
        for (let user of this.listUser) {
          this.teacherID = user.id;
        }
      });
    },
    fetchData(id) {
      http
        .get(`/getAllStudents/${id}`)
        .then((response) => {
          this.listUser = response.data.data;
          this.listUser = response.data.data;
          this.listUser.forEach((element) => {
            console.log(element.students);
            this.listUser = element.students;
          });
          console.log(this.listUser);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getRole() {
      let cookies = Cookies.get("user_role");
      this.role = cookies;
    },
  },
  mounted() {
    const id = this.$route.params.id;
    this.fetchData(id);
    this.getTeacherId();
    this.getRole();
    this.fetchTeacherData();
  },
};
</script>
<style scoped>
.give-feedback-container {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
  background-color: #fff;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
}

.give-feedback-container h2 {
  text-align: center;
  margin-bottom: 20px;
}

.give-feedback-container form {
  display: flex;
  flex-direction: column;
}

.give-feedback-container .form-group {
  margin-bottom: 20px;
}

.give-feedback-container textarea {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 5px;
  width: 100%;
}

.give-feedback-container select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 16px;
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  background-color: #fff;
}
.give-feedback-container select option:checked {
  background-color: #007bff;
  color: #fff;
}

.give-feedback-container select option {
  background-color: #fff;
  color: #000;
}


</style>
