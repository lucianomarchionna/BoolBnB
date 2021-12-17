<template>
  <section id="places" class="container my-5">
    <div class="row">
      <div class="col-12">
        <h3 class="mb-3 font-weight-bold">
          Ispirazioni per il tuo prossimo viaggio
        </h3>
        <h5 class="mb-3">Una casa ovunque nel mondo</h5>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 col-md-12 col-lg-4 mb-3">
        <a href="#" class="card border-0" @click="getClick">
          <div class="card-img h-100">
            <img
              src="https://images.unsplash.com/photo-1552832230-c0197dd311b5?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2596&q=80"
              alt="roma"
              class="w-100 h-100"
            />
          </div>
          <span class="card-overlay"></span
          ><span class="text-white fs-28">Roma</span>
        </a>
      </div>
      <div class="col-sm-12 col-md-12 col-lg-4 mb-3">
        <a href="#" class="card border-0" @click="getClick">
          <div class="card-img h-100">
            <img
              src="https://images.unsplash.com/photo-1610651219730-6b580d616e72?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MXx8dHVyaW4lMjBpdGFseXxlbnwwfHwwfHw%3D&auto=format&fit=crop&w=900&q=60"
              alt="torino"
              class="w-100 h-100"
            />
          </div>
          <span class="card-overlay"></span
          ><span class="text-white fs-28">Torino</span>
        </a>
      </div>
      <div class="col-sm-12 col-md-12 col-lg-4 mb-3">
        <a href="#" class="card border-0" @click="getClick">
          <div class="card-img h-100">
            <img
              src="https://images.unsplash.com/photo-1610016302534-6f67f1c968d8?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2275&q=80"
              alt="milano"
              class="w-100 h-100"
            />
          </div>
          <span class="card-overlay"></span
          ><span class="text-white fs-28">Milano</span>
        </a>
      </div>
    </div>
  </section>
</template>
<script>
export default {
  name: "Places",
  data() {
    return {
      destination: "",
    };
  },

  methods: {
    getClick(el) {
      this.$router.push({
        name: "Scopri | BoolBnB",
        params: { destination: el.target.innerText },
      });
    },
  },
};
</script>
<style lang="scss" scoped>
.card {
  position: relative;
  overflow: hidden;
  height: 250px;
  .card-overlay,
  .fs-28 {
    position: absolute;
    bottom: 0;
    text-align: center;
    transform: translateY(100%);
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    transition: 0.4s;
    font-weight: 900;
  }

  &:hover {
    img {
      filter: brightness(0.8);
    }
    .card-overlay,
    .fs-28 {
      transform: translateY(0);
    }
  }
}
</style>