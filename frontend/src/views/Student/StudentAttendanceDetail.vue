<template>
  <admin-dashboard v-if="this.role === '1'"></admin-dashboard>
  <teacher-dashboard v-else></teacher-dashboard>
  <main class="table mt-5">
    <h3 class="text-h5">
      Attendance Records :
      <span> {{ user.first_name }} {{ user.last_name }}</span>
    </h3>
    <v-table class="mt-4">
      <thead>
        <tr class="bg-teal-darken-4">
          <th class="text-white text-subtitle-1">Date</th>
          <th class="text-white text-subtitle-1">Reason</th>
          <th class="text-white text-subtitle-1">Attendance status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="record in attendanceRecords" :key="record.id">
          <td class="text-subtitle-1">{{ record.date }}</td>
          <td class="text-subtitle-1">{{ record.status }}</td>
          <td class="text-subtitle-1">{{ record.reason }}</td>
        </tr>
      </tbody>
    </v-table>
    <v-btn
      color="teal-darken-4"
      class="btn-container"
      :width="130"
      @click="generatePDF()"
      >save
    </v-btn>
  </main>
</template>

<script>
import axios from "axios";
import Cookies from "js-cookie";
import swal from "sweetalert2";
import jsPDF from "jspdf";
import http from "../../htpp.common";
import "jspdf-autotable";
export default {
  data() {
    return {
      role: "",
      user: {},
      attendanceRecords: [],
      pdfFile: null,
      telegramAPI:
        "https://api.telegram.org/bot6394729253:AAEuIrWM_GEvRqJ5kJ6Mpk4ZB7J0lmKMnfI/sendDocument", // replace with your Telegram bot token
    };
  },
  methods: {
    listattendance(id) {
      http
        .get("/getAttendance" + "/" + id)
        .then((response) => {
          this.user = response.data.user;
          this.attendanceRecords = response.data.attendanceRecords;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async getChatId(id) {
      try {
        const response = await http.get("/guardian" + "/" + `${id}`);
        this.chat_id = response.data.guardian_id;
        console.log(response.data.guardian_id);
      } catch (error) {
        console.error("Error getting chat ID:", error);
      }
    },

    // -----------ASK AI "how to sent pdf file to telagrambot"==================
    async sendPDF(chatId, pdfOutput) {
      try {
        const formData = new FormData();
        formData.append("chat_id", chatId);
        formData.append("document", pdfOutput, "Attendance.pdf");
        const response = await axios.post(this.telegramAPI, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });
        console.log(pdfOutput);
        if (!response.data.ok) {
          swal.fire("Failed", "Failed to send PDF", "error");
          return;
        }
        swal.fire({
          icon: "success",
          title: "PDF sent successfully!",
          text: "Your attendance report has been sent to the guardian",
          timer: 2000,
        });
      } catch (error) {
        console.error("Error sending PDF:", error);
        swal.fire("Error", "Failed to send PDF", "error");
      }
    },
    async generatePDF() {
      const document = new jsPDF("p", "pt", "a4");
      document.setFontSize(16);
      document.setFont("helvetica", "bold");
      document.text("Attendance Records", 40, 30);
      const name = `${this.user.first_name} ${this.user.last_name}`;
      document.text(`: ${name}`, 230, 30);
      const table = this.attendanceRecords.map((record) => [
        record.date,
        record.reason,
        record.status,
      ]);
      document.autoTable({
        head: [["Date", "Reason", "Attendance Status"]],
        body: table,
      });
      console.log(table);
      const pdfOutput = document.output("blob");
      await this.sendPDF(this.chat_id, pdfOutput);
      const fileName = `${name}_attendance.pdf`;
      document.save(fileName);
    },

    getRole() {
      let cookies = Cookies.get("user_role");
      this.role = cookies;
    },
  },
  mounted() {
    const id = this.$route.params.id;
    this.listattendance(id);
    this.getChatId(id);
    this.getRole();
  },
};
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: sans-serif;
}

main {
  margin-top: 10px;
  margin-left: 19%;
  width: 80%;
}

.button {
  margin-left: 89%;
}
.btn-container {
  margin-top: 10px;
  margin-left: 89%;
}
</style>
