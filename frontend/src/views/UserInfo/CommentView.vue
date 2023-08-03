<template>
    <student-dashboard></student-dashboard>
    <div class="main">
    <v-card class="elevation-4">
    <v-table>
    <thead class="thead ">
      <tr>
        <th class="name text-white text-subtitle-1">
          Teacher name
        </th>
        <th class=" text-white text-subtitle-1">
          Comments
        </th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="comment in comments"
        :key="comment.user_id"
      >
        <td>{{ comment.first_name }} {{ comment.last_name  }}</td>
        <td class="p-4">{{ comment.body }}</td>
      </tr>
    </tbody>
  </v-table>     
</v-card>
</div>
</template>
<script>
import http from "@/htpp.common";
import Cookies from "js-cookie";
export default {
  name: "UserDetails",
  data() {
    return {
      comments: " ",
      role: "",
    };
  },
  methods: {
    fetchData() {
      http.get("/v1/auth/user").then((response) => {
        this.comments = response.data.data.comments;
        console.log('comment',this.comments);
      });
    },
    getRole() {
      let cookies = Cookies.get("user_role");
      this.role = cookies;
    },
  },



  mounted() {
    this.fetchData();
    this.getRole();
  },
};

</script>

<style>
.main{
    margin-top: 10px;
    width: 80%;
    margin-left: 18%;
}

.thead{
    background: #004D40;
}
.name{
  width: 15%;
}

</style>