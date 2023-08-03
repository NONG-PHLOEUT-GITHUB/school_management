<template>
  <div class="d-flex align-items-center justify-content-center vh-100">
    <div class="text-center col">
      <v-col>
        <p class="fs-3">
          <span class="text-danger">Opps!</span> Page not found.
        </p>
        <p class="lead">The page you are looking for doesn't exist.</p>
        <img
          src="https://img.freepik.com/vector-premium/ingeniero-tablero-error-404_736395-1.jpg"
          alt=""
        />
      </v-col>
      <v-btn class="w-25 text-white" :to="'/login'" color="teal-darken-4"
        >Login</v-btn
      >
    </div>
  </div>
</template>
