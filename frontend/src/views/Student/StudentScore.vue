<template>
  <teacher-dashboard></teacher-dashboard>
  <div class="card shadow border-0 mb-7">
    <label for="file-input">Choose class for input score</label>
    <select
      class="form-select mb-3 mt-2"
      aria-label="Default select example"
      style="width: 30%"
      v-model="selectedClass"
      @click="getStudentInClass(selectedClass)"
    >
      <option value="noChoosen">No choosen</option>
      <option
        v-for="classroom in classrooms"
        :key="classroom.id"
        :value="classroom.id"
      >
        {{ classroom.class_name }}
      </option>
    </select>
    <label for="">Select date</label>
    <input v-model="month" class="date" type="date" />
    <div class="table-responsive">
      <table class="table table-hover table-nowrap">
        <thead class="thead">
          <tr>
            <th scope="col" class="text-subtitle-2 text-light">Name</th>
            <th scope="col" class="text-subtitle-2 text-light">Khmer</th>
            <th scope="col" class="text-subtitle-2 text-light">Math</th>
            <th scope="col" class="text-subtitle-2 text-light">English</th>
            <th scope="col" class="text-subtitle-2 text-light">History</th>
            <th scope="col" class="text-subtitle-2 text-light">Biology</th>
            <th scope="col" class="text-subtitle-2 text-light">Geo</th>
            <th scope="col" class="text-subtitle-2 text-light">ES</th>
            <th scope="col" class="text-subtitle-2 text-light">MC</th>
            <th scope="col" class="text-subtitle-2 text-light">Chemish</th>
            <th scope="col" class="text-subtitle-2 text-light">Physics</th>
            <th scope="col" class="text-subtitle-2 text-light">Sport</th>
            <th scope="col" class="text-subtitle-2 text-light">ICT</th>
            <th scope="col" class="text-subtitle-2 text-light">Total</th>
            <th scope="col" class="text-subtitle-2 text-light">Average</th>
          </tr>
        </thead>

        <tbody v-if="listUser && listUser.length">
          <tr
            class="border-secondary "
            v-for="student in listUser"
            :key="student.id"
          >
            <td class="text-subtitle-1">
              <input
                class="form-check-input"
                type="checkbox"
                @click="getStudentId(student.id)"
                v-model="student.selected"
              />
              {{ student.first_name }} {{ student.last_name }}
            </td>
            <td>
              <input
                type="number"
                class="form-control score_input"
                v-on:keyup="getScore(student)"
                v-model="student.K"
              />
            </td>
            <td>
              <input
                type="number"
                class="form-control score_input"
                v-on:keyup="getScore(student)"
                v-model="student.M"
              />
            </td>
            <td>
              <input
                type="number"
                class="form-control score_input"
                v-on:keyup="getScore(student)"
                v-model="student.E"
              />
            </td>
            <td>
              <input
                type="number"
                class="form-control score_input"
                v-on:keyup="getScore(student)"
                v-model="student.H"
              />
            </td>
            <td>
              <input
                type="number"
                class="form-control score_input"
                v-on:keyup="getScore(student)"
                v-model="student.B"
              />
            </td>
            <td>
              <input
                type="number"
                class="form-control score_input"
                v-on:keyup="getScore(student)"
                v-model="student.GEO"
              />
            </td>
            <td>
              <input
                type="number"
                class="form-control score_input"
                v-on:keyup="getScore(student)"
                v-model="student.ES"
              />
            </td>
            <td>
              <input
                type="number"
                class="form-control score_input"
                v-on:keyup="getScore(student)"
                v-model="student.MC"
              />
            </td>
            <td>
              <input
                type="number"
                class="form-control score_input"
                v-on:keyup="getScore(student)"
                v-model="student.CH"
              />
            </td>
            <td>
              <input
                type="number"
                class="form-control score_input"
                v-on:keyup="getScore(student)"
                v-model="student.P"
              />
            </td>
            <td>
              <input
                type="number"
                class="form-control score_input"
                v-on:keyup="getScore(student)"
                v-model="student.SP"
              />
            </td>
            <td>
              <input
                type="number"
                class="form-control score_input"
                v-on:keyup="getScore(student)"
                v-model="student.ICT"
              />
            </td>
            <td class="text-subtitle-1">{{ getTotalScore(student) }}</td>
            <td class="text-subtitle-1">{{ getAverageScore(student) }}</td>
          </tr>
        </tbody>
        <tr v-else>
          <td colspan="6" class="text-center text-danger">
            This class does not have any students.
          </td>
        </tr>
      </table>
    </div>
    <div class="submit-score w-100">
      <v-btn type="submit" color="teal-darken-4" @click="SubmitScoreSubject">
        Submit score</v-btn
      >
    </div>
  </div>
</template>

<script>
import axios from "axios";
import swal from "sweetalert2";
import http from "../../htpp.common";
import LRU from "lru-cache";

const cache = new LRU(100);
export default {
  data() {
    return {
      listUser: [],
      URL: "http://127.0.0.1:8000/api/getStudents",
      id_user: 0,
      user_id: "",
      subject_id: "",
      score: "",
      subjectName: "",
      subjects: [],
      classrooms: [],
    };
  },
  methods: {
    // get all student
    getStudent() {
      axios.get(this.URL).then((response) => {
        this.listUser = response.data.data;
        console.log(this.listUser);
      });
    },
    // get student id
    getStudentId(id) {
      axios
        .get(this.URL + "/" + `${id}`)
        .then((response) => {
          this.id_user = response.data.id;
          console.log(this.id_user);
        })
        .catch((error) => {
          console.error(error);
        });
    },
    // get score form input number
    getScore(student) {
      let scores = [];
      for (var subject in student) {
        if (typeof student[subject] === "number") {
          scores.push(student[subject]);
        }
      }
      return scores;
    },
    // submit score and subject to database
    SubmitScoreSubject() {
      // Map the subjects array to an array of objects with subject_name and subject_score properties
      const subjectsData = this.subjects.map((value) => ({
        subject_name: value.subject_name,
        subject_score: value.subject_score,
      }));
      let subjectInput = "";
      let scoreInput = 0;
      for (let value of subjectsData) {
        scoreInput = value.subject_score;
        if (value.subject_name == "K") {
          subjectInput = 1;
        } else if (value.subject_name == "M") {
          subjectInput = 2;
        } else if (value.subject_name == "E") {
          subjectInput = 3;
        } else if (value.subject_name == "H") {
          subjectInput = 4;
        } else if (value.subject_name == "B") {
          subjectInput = 5;
        } else if (value.subject_name == "GEO") {
          subjectInput = 6;
        } else if (value.subject_name == "ES") {
          subjectInput = 7;
        } else if (value.subject_name == "MC") {
          subjectInput = 8;
        } else if (value.subject_name == "CH") {
          subjectInput = 9;
        } else if (value.subject_name == "P") {
          subjectInput = 10;
        } else if (value.subject_name == "SP") {
          subjectInput = 11;
        } else if (value.subject_name == "ICT") {
          subjectInput = 12;
        }
      }
      console.log(subjectInput);

      // Create an object with user_id and subjects properties
      const postData = {
        score: scoreInput,
        subject_id: subjectInput,
        month: this.month,
        user_id: this.id_user,
      };
      console.log(postData);

      // Send a POST request to the API endpoint with the postData as the request body
      http
        .post("/scores", postData)
        .then((response) => {
          response.data;
          console.log(postData);
          swal.fire({
            icon: "success",
            title: "Send score successfully!",
            text: "you already send score with subject.",
            timer: 2000,
          });
        })
        .catch((error) => {
          console.error(error);
        });
    },
    getStudentInClass(classId) {
      http
        .get(`/get-students`)
        .then((response) => {
          if (!this.selectedClass || this.selectedClass == "noChoosen") {
            this.listUser = response.data.data;
          } else {
            this.listUser = response.data.data.filter(
              (teacher) => parseInt(teacher.class_room_id) === parseInt(classId)
            );
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async getClassrooms() {
      const cachedResponse = cache.get("teacher_classroom");

      if (cachedResponse) {
        this.classrooms = cachedResponse;
        return;
      }

      try {
        const response = await http.get("/v1/auth/user");
        this.classrooms = response.data.data.class_teacher;
        cache.set("teacher_classroom", this.classrooms);
      } catch (error) {
        console.error(error);
      }
      if (this.classrooms.length === 0) {
        this.snackbar = true;
      }
    },
  },
  computed: {
    // compute total of score that we have been inputed
    getTotalScore() {
      return function (student) {
        let total = 0;
        let subject_name = "";
        let subjectScore = "";
        const subjects = [
          "K",
          "M",
          "E",
          "H",
          "B",
          "GEO",
          "ES",
          "MC",
          "CH",
          "P",
          "SP",
          "ICT",
        ];
        for (var i = 0; i < subjects.length; i++) {
          const subject = subjects[i];
          if (
            typeof student[subject] === "number" &&
            !isNaN(student[subject])
          ) {
            subject_name = subjects[i];
            subjectScore = student[subject];
            total += student[subject];

            // Check if the subject already exists in the array
            const existingSubjectIndex = this.subjects.findIndex(
              (s) => s.subject_name === subject_name
            );
            if (existingSubjectIndex !== -1) {
              // Update the subject_score property of the existing object
              this.subjects[existingSubjectIndex].subject_score = subjectScore;
            } else {
              // Push a new object to the array
              this.subjects.push({
                subject_name: subject_name,
                subject_score: subjectScore,
              });
            }
          }
        }
        return total;
      };
    },
    // get average score that we have been inputed
    getAverageScore() {
      return function (student) {
        let total = this.getTotalScore(student);
        return (total / 12).toFixed(2);
      };
    },
  },
  mounted() {
    this.getStudentInClass();
    this.getClassrooms();
    return this.getStudent();
  },
};
</script>

<style scoped>
.score_input {
  border: 1px solid rgb(97, 93, 93);
  padding: 6px;
  margin-left: -10%;
  width: 50px;
  height: 30px;
}

.btn-submit {
  margin: 1%;
  margin-left: 40%;
  color: white;
  width: 30%;
}

.card {
  margin-left: 18%;
  margin-right: 10px;
  padding: 10px;
}

.submit-score {
  display: flex;
  justify-content: flex-end;
  width: 100%;
}

.thead{
  background-color: #004D40;
}

.date{
  border: solid 1px;
  margin-top: 10px;
  margin-bottom: 40px;
  padding: 10px;
  width: 30%;
  border-radius: 10px;
}
</style>
