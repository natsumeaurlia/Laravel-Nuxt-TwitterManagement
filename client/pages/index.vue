<template>
  <div class="d-flex justify-space-around align-center flex-column flex-md-row fill-height">
    <v-btn
        color="primary"
    >
      Normal Button
    </v-btn>

    <v-btn
        rounded="lg"
        color="primary"
    >
      Rounded Button
    </v-btn>

    <v-btn
        :rounded="0"
        color="primary"
    >
      Tile Button
    </v-btn>

    <v-btn
        rounded="pill"
        color="primary"
    >
      Pill Button
    </v-btn>
    <v-alert
        variant="outlined"
        color="purple"
        class="ma-2"
    >
      <div class="text-h6">
        Lorem Ipsum
      </div>
      <div>Maecenas ullamcorper, dui et placerat feugiat, eros pede varius nisi, condimentum viverra felis nunc et lorem. Duis vel nibh at velit scelerisque suscipit. Praesent blandit laoreet nibh. Aenean posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin urna dolor sagittis lacus. Etiam sollicitudin, ipsum eu pulvinar rutrum, tellus ipsum laoreet sapien, quis venenatis ante odio sit amet eros.</div>
    </v-alert>
  </div>
</template>