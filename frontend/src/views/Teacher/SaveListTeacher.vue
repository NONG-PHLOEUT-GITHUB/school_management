<template>
  <admin-dashboard></admin-dashboard>
  <v-card class="table-container mt-4">
    <h3 class="ms-6">TEACHER LIST</h3>
    <label for="" class="mt-4 ms-4">Select teacher</label>
    <select class="form-select mb-3 ms-4 mt-2" aria-label="Default select example" style="width: 30%" v-model="selectedClass"
      @click="getTeacher(selectedClass)">

      <option v-for="classroom in classrooms" :key="classroom.id" :value="classroom.id">
        {{ classroom.class_name }}
      </option>
    </select>
    <table id="my-table">
      <v-table class="pa-6">
        <thead>
          <tr>
            <th class="text-white">No</th>
            <th class="text-white">First Name</th>
            <th class="text-white">Last Name</th>
            <th class="text-white">Gender</th>
            <th class="text-white">Age</th>
            <th class="text-white">Date of Birth</th>
            <th class="text-white">Phone Number</th>
            <th class="text-white">Address</th>
            <th class="text-white">Email</th>
          </tr>
        </thead>
        <tbody v-if="listUser && listUser.length">
          <tr v-for="(student, index) in listUser" :key="student.id">
            <td class="text-subtitle-1">{{ index + 1 }}</td>
            <td class="text-subtitle-1">{{ student.first_name }}</td>
            <td class="text-subtitle-1">{{ student.last_name }}</td>
            <td class="text-subtitle-1">{{ student.gender }}</td>
            <td class="text-subtitle-1">{{ student.age }}</td>
            <td class="text-subtitle-1">{{ student.date_of_birth }}</td>
            <td class="text-subtitle-1">{{ student.phone_number }}</td>
            <td class="text-subtitle-1">{{ student.address }}</td>
            <td class="text-subtitle-1">{{ student.email }}</td>
          </tr>
        </tbody>
        <tbody v-else>
          <tr>
            <td colspan="9">No Teachers found in the selected class.</td>
          </tr>
        </tbody>
      </v-table>
    </table>
    <div class="icon pa-4">
      <v-btn v-if="!isDownloading" @click="downloadPDF()">
        <v-icon size="24">mdi-download</v-icon>
        Download PDF
      </v-btn>
      <div v-else>
        <p>Generating PDF...</p>
        <i class="fa fa-spinner fa-spin"></i>
      </div>
      <a v-if="pdfUrl" :href="pdfUrl" download="file.pdf"></a>
    </div>
  </v-card>
</template>

<script>
import jsPDF from "jspdf";
import html2canvas from "html2canvas";
import http from "../../htpp.common";
import AdminDashboard from "../../components/AdminDashboard.vue";
export default {
  components: { AdminDashboard },
  data() {
    return {
      isDownloading: false,
      isDetail: false,
      pdfUrl: null,
      listUser: [],
      selectedClass: null,
      classrooms: [],
    };
  },
  // https://stackoverflow.com/questions/63789573/html2canvas-with-jspdf-in-vue-cli-application-dont-work and with AI
  methods: {
    // download pdf ==================================
    downloadPDF() {
      this.isDetail = true;
      http
        .get("/get-teachers")
        .then((response) => {
          this.teachers = response.data.data;
          const element = document.getElementById("my-table");
          html2canvas(element).then((canvas) => {
            const imgData = canvas.toDataURL("image/png");
            const pdf = new jsPDF();
            const imgProps = pdf.getImageProperties(imgData);
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
            pdf.addImage(imgData, "JPEG", 0, 0, pdfWidth, pdfHeight);
            pdf.save("download.pdf");
            this.isDetail = false;
            this.fetchData();
          });
        })
        .catch((error) => {
          console.error(error);
        });
    },
    fetchData() {
      http
        .get("/get-teachers")
        .then((response) => {
          this.listUser = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getClassrooms() {
      http
        .get("/classrooms")
        .then((response) => {
          this.classrooms = response.data.data;
        })
        .catch((error) => {
          console.log("Error fetching classrooms:", error);
        });
    },
    getTeacher(classId) {
      if (!classId) {
        http
          .get(`/get-teachers`)
          .then((response) => {
            this.listUser = response.data.data;
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        http
          .get(`/get-teachers`)
          .then((response) => {
            this.listUser = response.data.data.filter(
              (teacher) => parseInt(teacher.class_room_id) === parseInt(classId)
            );
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
  },
  mounted() {
    this.getClassrooms();
    this.getTeacher();
    this.fetchData();
  },
};
</script>

<style scoped>
@import url(https://fonts.googleapis.com/css?family=Open+Sans:400,600,700);

/* Bootstrap Icons */
@import url("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css");

/* Set styles for the table */
table {
  border-collapse: collapse;
  width: 100%;
  margin-bottom: 20px;
}

td {
  text-align: left;
  padding: 8px;
  border-bottom: 1px solid #ddd;
}

th {
  background-color:#004D40;
  color: white;
}

.table-container {
  margin-left: 18%;
  margin-right: 2px;
}

.icon {
  display: flex;
  justify-content: flex-end;
}
</style>
