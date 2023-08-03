<template>
  <div class="card shadow border-0 mb-7 d-flex bg-gray-300">
    <div class="d-flex align-items-center title">
      <h3>Add score for</h3>
      <div v-for="student of students" :key="student">
        <h2 class="ml-2">{{ student.first_name }} {{ student.last_name }}</h2>
      </div>
    </div>
    <div class="d-flex align-items-center justify-content-center">
      <div class="col-md-4">
        <label for="validationCustom02" class="form-label">Subject</label>
        <select
          class="form-select border-secondary"
          aria-label="Default select example"
          v-model="subjectName"
          @click="getSubject(subjectName)"
        >
          <option selected disabled>Select Subject</option>
          <option value="M">Math</option>
          <option value="K">Khmer</option>
          <option value="CH">Chemistry</option>
          <option value="P">Physics</option>
          <option value="H">History</option>
          <option value="B">Biology</option>
          <option value="E">English</option>
          <option value="G">Geography</option>
          <option value="ES">Earth Science</option>
          <option value="MC">Morality-Civics</option>
          <option value="SP">Sports</option>
        </select>
      </div>

      <div class="col-md-4 ml-2 border-secondary">
        <label for="validationCustom02" class="form-label">Score</label>
        <input
          type="number"
          value="0"
          class="form-control"
          id="phoneNumber"
          placeholder=""
        />
      </div>
    </div>
    <div class="col-10 d-flex justify-content-end mt-5 mb-5">
      <button type="submit" class="btn btn-warning text-white">Cancel</button>
      <button type="submit" class="btn btn-primary text-white ml-2">
        Add Score
      </button>
    </div>
  </div>
</template>

<script>
import http from "@/htpp.common";
export default {
  data() {
    return {
      URL: `http://127.0.0.1:8000/api/users/${this.$route.params.id}`,
      subjectName: "",
      students: [],
    };
  },
  methods: {
    // get subject of student
    getSubject() {
      console.log(this.subjectName);
    },
  },
  mounted() {
    http.get(`/users/${this.$route.params.id}`).then((response) => {
      this.students = response.data;
      console.log(this.students);
    });
  },
};
</script>

<style scoped>
h3 {
  color: #0000ff;
}
.title {
  padding: 15px;
  margin: auto;
}
</style>
