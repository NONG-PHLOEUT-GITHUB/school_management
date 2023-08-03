<template>
  <admin-dashboard> </admin-dashboard>
  <div class="container">
    <v-autocomplete
      label="Autocomplete"
      :items="[
        'California',
        'Colorado',
        'Florida',
        'Georgia',
        'Texas',
        'Wyoming',
      ]"
      variant="outlined"
    ></v-autocomplete>
  </div>
</template>

<style scoped>
.container {
  width: 50%;
  margin-left: 18%;
  margin-top: 10px;
}
</style>
