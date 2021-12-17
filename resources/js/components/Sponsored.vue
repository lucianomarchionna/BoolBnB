<template>
  <section id="sponsored" class="my-5">
    <div class="container">
      <div class="row mb-3">
        <div class="col-12">
          <h3 class="mb-3"><strong>Le nostre case in evidenza</strong></h3>
          <h5 class="mb-0">
            Soggiorna nelle migliori abitazioni del multiverso per un'esperienza
            indimenticabile
          </h5>
        </div>
      </div>

      <div class="row flex-row-reverse justify-content-end">
        <router-link
          :to="{
            name: 'Dettaglio | BoolBnB',
            params: { slug: apartment.slug },
          }"
          class="
            col-5 col-md-3
            card
            border-0
            m-2
            px-0
            text-reset text-decoration-none
          "
          v-for="apartment in apartments"
          :key="apartment.id"
        >
          <img
            :src="'/storage/' + apartment.image"
            class="card-img-top"
            alt=""
          />
          <div class="card-body">
            <h5 class="card-title font-weight-bold">{{ apartment.title }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">
              {{ apartment.type }}
            </h6>
            <p class="card-text text-truncate">
              {{ apartment.description }}
            </p>
          </div>
        </router-link>
      </div>
    </div>
  </section>
</template>
<script>
export default {
  name: "Sponsored",
  data() {
    return {
      apiSponsors: "/api/sponsored/",
      apartments: [],
    };
  },
  methods: {
    getSponsoredHouses() {
      axios.get(this.apiSponsors).then((res) => {
        this.apartments = res.data.results;
      });
    },
  },
  created() {
    this.getSponsoredHouses();
  },
};
</script>
<style lang="scss" scoped>
.card {
  transition: 0.5s;
  &:hover {
    transform: translateY(-5%);
  }
}
.card-img-top {
  height: 200px;
  width: 100%;
  object-fit: cover;
}
</style>