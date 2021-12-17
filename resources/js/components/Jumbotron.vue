<template>
  <section id="jumbotron" class="position-relative text-white mb-5">
    <div class="bg-overlay"></div>
    <div class="container">
      <div class="row align-items-center flex-column mb-4">
        <div class="col-auto mx-auto text-center">
          <h2 class="mb-4 title-jumbotron">
            <strong
              >Scopri nuovi posti e partecipa a esperienze fantastiche!</strong
            >
          </h2>
          <h5 class="mb-0">Inizia scegliendo la tua prossima destinazione</h5>
        </div>
      </div>

      <div class="row">
        <div class="input-group mb-3">
          <input
            type="text"
            class="form-control h-100 form-control-lg pl-5"
            id="input_destination"
            v-model="destination"
            v-on:keyup.enter="searchDestination"
            placeholder="Dove Vuoi Andare?"
            aria-label="Destination"
            aria-describedby="button-addon2"
          />
          <div class="input-group-append d-flex align-items-center">
            <router-link
              :to="{
                name: 'Scopri | BoolBnB',
              }"
              class="
                btn btn-outline-danger
                bg-danger
                text-light
                h-100
                d-flex
                align-items-center
              "
              @click="searchDestination"
              ><svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="feather feather-search"
              >
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
              </svg>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "Jumbotron",
  data() {
    return {
      destination: "",
    };
  },
  methods: {
    searchDestination() {
      this.$router.push({
        name: "Scopri | BoolBnB",
        params: { destination: this.destination },
      });
    },
  },
};
</script>

<style lang="scss" scoped>
#jumbotron {
  background-image: url("https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2670&q=80");
  background-size: cover;
  background-position: center;
  .title-jumbotron {
    font-size: 3.5em;
    font-weight: 800;
  }
  .bg-overlay {
    position: absolute;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.387);
  }
}
</style>