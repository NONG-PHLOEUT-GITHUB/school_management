<template>
  <teacher-dashboard></teacher-dashboard>
  <div class="container mt-5 ">
    <v-card class="elevation-4 mb-4">
      <v-btn block color="teal-darken-4">attendance check list</v-btn>
      <br />
      <div>
        <label for="" class="ms-8">Select class</label>
        <select class="form-select mb-3 ms-8" aria-label="Default select example" style="width: 30%"
          v-model="selectedClass" @click="getStudentInClass(selectedClass)">
          <option selected disabled>Select class</option>
          <option v-for="classroom in classrooms" :key="classroom.id" :value="classroom.id">
            {{ classroom.class_name }}
          </option>
        </select>
      </div>
      <div class="checkToday d-flex w-25">
        <v-checkbox @click="SelectAttendace()" class="selectattendance" value="red" label="Attendance Today" hide-details>
        </v-checkbox> : {{ this.date }}
      </div>

      <table>
        <thead>
          <tr>
            <th>Selected</th>
            <th>FirstName</th>
            <th>LastName</th>
            <th>Gender</th>
            <th>Status</th>
            <th>Reason</th>
          </tr>
        </thead>
        <tbody v-if="students && students.length">
          <tr v-for="student in students" :key="student.id">
            <td class="text-center">
              <v-checkbox @click="getChatId(student.id)" v-model="student.selected" class="selectstudent" color="red"
                value="red" hide-details></v-checkbox>
            </td>
            <td>{{ student.first_name }}</td>
            <td>{{ student.last_name }}</td>
            <td>{{ student.gender }}</td>
            <td>
              <div class="dropdown rounded-1">
                <select class="form-select align-self-end" v-model="student.status" aria-label="Default select example"
                  id="validationCustom01">
                  <option selected disabled>Select status</option>
                  <option value="Present">Present</option>
                  <option value="Absent">Absent</option>
                  <option value="Early">Early</option>
                  <option value="Excused">Excused</option>
                  <option value="Unexcused">Unexcused</option>
                  <option value="On leave">On leave</option>
                  <option value="No show">No show</option>
                </select>
              </div>
            </td>
            <td>
              <textarea type="tel" v-model="student.reason" class="form-control" id="reason" placeholder="" />
            </td>
          </tr>
        </tbody>
        <tbody v-else>

          <tr>
            <td colspan="6" class="text-center text-danger">
              This class does not have any students.
            </td>
          </tr>
        </tbody>
      </table>

      <div class="col-12 d-flex justify-content-end btn">
        <v-btn type="submit" @click="submitForm()" color="teal-darken-4">Save</v-btn>
      </div>
    </v-card>
  </div>
</template>
<script>
import swal from "sweetalert2";
import axios from "axios";
import http from "../../htpp.common";
import LRU from "lru-cache";

const cache = new LRU(100);
export default {
  name: "SweetAlert2",
  data() {
    return {
      students: [],
      date: null,
      chat_id: null,
      classrooms: [],

    };
  },
  methods: {
    SelectAttendace() {
      const today = new Date();
      const date =
        today.getFullYear() +
        "-" +
        (today.getMonth() + 1) +
        "-" +
        today.getDate();
      this.date = date;
      this.students.forEach((student) => {
        student.status = false;
      });
    },
    async saveListAttendence() {
      try {
        const responses = await Promise.all(
          this.students.map((student) => {
            if (
              student.status !== "" &&
              student.reason !== "" &&
              this.date !== null
            ) {
              const newAttend = {
                attendance_status: student.status,
                date: this.date,
                reason: student.reason,
              };
              // console.log(newAttend);
              return http.post("/checkStudentAttendance", newAttend);
            } else {
              swal.fire("Complete first", "complete all input", "info");
            }
          })
        );
        console.log(responses);
        swal.fire({
          icon: "success",
          title: "Save attendance successfully!",
          text: "you already save your attendance",
          timer: 2000,
        });
      } catch (error) {
        console.error(error);
        swal.fire("Error", "Failed to save attendance", "error");
      }
    },

    // ASk AI "how to sent attendance of stundet to parent"
    // https://www.youtube.com/watch?v=aNmRNjME6mE
    async getChatId(id) {
      try {
        const response = await http.get("/guardian" + "/" + `${id}`);
        this.chat_id = response.data.guardian_id;
        console.log(response.data.guardian_id);
      } catch (error) {
        console.error("Error getting chat ID:", error);
      }
    },

    async submitForm() {
      try {
        const telegramAPI =
          "https://api.telegram.org/bot6394729253:AAEuIrWM_GEvRqJ5kJ6Mpk4ZB7J0lmKMnfI/sendMessage"; 
        const selectedStudents = this.students.filter(
          (student) =>
            student.selected && student.status !== "" && student.reason !== ""
        );
        if (selectedStudents.length === 0) {
          swal.fire("Error", "Please select at least one student", "error");
          return;
        }
        for (const student of selectedStudents) {
          await this.getChatId(student.id); // pass the guardian_id as the parameter
          const message = `Name: ${student.first_name} ${student.last_name}\nGender: ${student.gender}\nStatus: ${student.status}\nReason: ${student.reason}`;
          const response = await axios.post(telegramAPI, {
            chat_id: this.chat_id,
            text: message,
          });
          if (!response.data.ok) {
            swal.fire("Failed", "Failed to send message", "error");
            return;
          }
          // Create an attendance object for the current student
          const attendanceData = {
            id: this.selectedClass,
            user_id: student.id,
            status: student.status,
            reason: student.reason,
            date: this.date,
          };
          student.status = "",
            student.reason = "",
            this.reason = "",
            student.selected = "",
            this.date = "",
            // Send the attendance data to your API
            http.post("/checkStudentAttendance", attendanceData)
              .catch((error) => {
                console.log(error);
              });
        }
        swal.fire({
          icon: "success",
          title: "Message sent successfully!",
          text: "Your attendance has been saved and the message has been sent to the guardian",
          timer: 2000,
        });
      } catch (error) {
        console.error("Error sending message:", error);
        swal.fire("Error", "Failed to send message", "error");
      }
    },

    getStudentData() {
      http.get('/get-students')
        .then((response) => {
          this.students = response.data.data;

        });
    },
    getStudentInClass(classId) {
      http
        .get(`/get-students`)
        .then((response) => {
          console.log(response.data.data);
          this.students = response.data.data;
          this.students = response.data.data.filter(
            (teacher) => parseInt(teacher.class_room_id) === parseInt(classId)
          );
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

  created() {
    setInterval(this.getCurrentDateTime, 1000);
  },
  mounted() {
    this.getStudentInClass();
    this.getClassrooms();
    this.getStudentData();
  },
};
</script>

<style  scoped>
table {
  padding: 2%;
  width: 100%;
  /* box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px; */
}

table {
  border-collapse: collapse;
  width: 95%;
  margin-top: 20px;
  margin-bottom: 20px;
  margin-left: 3%;
}

th,
td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: center;
}

th {
  background-color: #004D40;
  text-align: center;
  color: white;
}

td.status {
  position: relative;
  padding-left: 30px;
}

.btn {
  margin-right: 0.5%;
}

.selectattendance {
  padding: 10px;
  margin-left: 34px;
}

.container {
  width: 84%;
  margin-left: 17%;
}

.checkToday {
  justify-content: center;
  align-items: center;
}
</style>
