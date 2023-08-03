<template>
  <student-dashboard />
  <student-graph></student-graph>
</template>
<script>
import StudentGraph from "./StudentGraph.vue";

export default {
  components: {
    StudentGraph,
  },
};
</script>

<style scoped>
@import "~vuetify/dist/vuetify.css";

.sheet {
  margin-top: 10px;
  margin-left: 19%;
}
</style>
