<template>
  <section>
    <div v-if="!isLoading" class="row">
      <div class="col-md-12">
        <div class="d-flex justify-content-center img-container">
          <img
            class="apartments-img w-100 h-100"
            :src="'/storage/' + apartment.image"
            alt="Image inserted"
          />
        </div>
        <div class="container my-3">
          <p class="fs-25 font-weight-bold pt-3 m-0">{{ apartment.title }}</p>
          <p class="fs-15">
            <i class="fas fa-map-marker-alt fs-15"></i> {{ apartment.city }},
            {{ apartment.street }}, {{ apartment.house_number }}
          </p>

          <div class="div-bordered text-center mt-3">
            <div class="p-4">
              <i class="fas fa-home fs-30 color-grey-icon"></i>
              <p class="fs-15 text-capitalize font-weight-bold">
                Tipologia {{ apartment.type }}
              </p>
            </div>
          </div>

          <div class="div-bordered d-flex text-center mb-3">
            <div
              class="
                div-bordered-2 div-bordered-3 div-bordered-4
                icon-separation
                p-4
              "
            >
              <i class="fas fa-bed fs-20 color-grey-icon"></i>
              <p class="fs-15 text-capitalize font-weight-bold">
                {{ apartment.n_beds }} Letti
              </p>
            </div>
            <div class="div-bordered-2 div-bordered-3 icon-separation p-4">
              <i class="fas fa-door-closed fs-20 color-grey-icon"></i>
              <p class="fs-15 text-capitalize font-weight-bold">
                {{ apartment.n_rooms }} Stanze
              </p>
            </div>
            <div class="div-bordered-3 icon-separation p-4">
              <i class="fas fa-user-friends fs-20 color-grey-icon"></i>
              <p class="fs-15 text-capitalize font-weight-bold">
                Fino a {{ apartment.n_guests }} Persone
              </p>
            </div>
            <div
              class="
                div-bordered-2 div-bordered-3 div-bordered-4
                icon-separation
                p-4
              "
            >
              <i class="far fa-clone fs-20 color-grey-icon"></i>
              <p class="fs-15 text-capitalize font-weight-bold">
                {{ apartment.mq }} m<sup>2</sup>
              </p>
            </div>
          </div>

          <h4 class="font-weight-bold">Descrizione dell'appartamento</h4>
          <p class="fs-15 pb-3 div-bordered-3">{{ apartment.description }}</p>

          <div class="pb-3 div-bordered-3">
            <h4 class="font-weight-bold">Caratteristiche</h4>
            <div class="details-apartments d-flex justify-content-around">
              <div class="details-left">
                <p class="fs-15">
                  <i class="far fa-circle fs-12"></i> ID: {{ apartment.id }}
                </p>
                <p class="fs-15">
                  <i class="far fa-circle fs-12"></i> Possibilità di portare animali: {{ apartment.pet }}
                </p>
                <p class="fs-15">
                  <i class="far fa-circle fs-12"></i> Orario Checkin:
                  {{ apartment.h_checkin }}
                </p>
                <p class="fs-15">
                  <i class="far fa-circle fs-12"></i> Orario Checkout:
                  {{ apartment.h_checkout }}
                </p>
              </div>
              <div class="details-right">
                <p class="fs-15">
                  <i class="far fa-circle fs-12"></i> Tipo di alloggio: {{ apartment.type }}
                </p>
                <p class="fs-15">
                  <i class="far fa-circle fs-12"></i> Città: {{ apartment.city }}
                </p>
                <p class="fs-15">
                  <i class="far fa-circle fs-12"></i> Indirizzo:
                  {{ apartment.street }}
                </p>
                <p class="fs-15">
                  <i class="far fa-circle fs-12"></i> N° Civico:
                  {{ apartment.house_number }}
                </p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="row flex-column">
                <h4 class="font-weight-bold pt-3">Servizi aggiuntivi</h4>
                <div
                  class="
                    additional_services
                    d-flex
                    div-bordered-3
                    flex-wrap
                    pt-2
                    pb-3
                  "
                >
                  <div
                    class="pr-4"
                    v-for="service in services"
                    :key="service.id"
                  >
                    <p class="fs-15">
                      <i class="fs-15" :class="service.icon"></i>
                      {{ service.name }}
                    </p>
                  </div>
                </div>
              </div>
              <div class="row flex-column">
                <h4 class="font-weight-bold pt-3">Prezzo</h4>
                <p class="fs-15 pb-3 div-bordered-3">
                  <i class="fas fa-chevron-right fs-12"></i>
                  {{ apartment.price_night }} € / notte
                </p>
              </div>
            </div>
            <div class="col-6">
              <div id="map" class="map">
                <img
                  :src="`https://api.tomtom.com/map/1/staticimage?key=6pyK2YdKNiLrHrARYvnllho6iAdjMPex&zoom=16&center=${apartment.long},${apartment.lat}&format=jpg&layer=basic&style=main&width=1305&height=748&view=Unified&language=en-GB`"
                  alt="Mappa"
                  class="w-100"
                />
                <i class="fas fa-map-pin"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <ContactForm :apartment="apartment" />
  </section>
</template>
<script>
import ContactForm from "../components/ContactForm";
export default {
  name: "Apartment",
  components: { ContactForm },
  data() {
    return {
      apiUrl: "/api/apartment/",
      apartment: [],
      apartmentId: "",
      userIp: "",
      isLoading: true,
      apiIPurl: "https://api.ipify.org/",
      img: "",
      services: [],
    };
  },
  mounted() {
    axios
      .all([
        axios.get(this.apiUrl + this.$route.params.slug),
        axios.get(this.apiIPurl),
      ])
      .then(
        axios.spread((res, res2) => {
          this.apartment = res.data.results;
          this.apartmentId = res.data.results.id;
          this.userIp = res2.data;
          this.services = res.data.results.services;
        })
      )
      .catch(
        axios.spread((err, err2) => {
          console.log(err, err2);
        })
      )
      .finally(() => {
        this.sendData();
      });
  },
  methods: {
    sendData() {
      let today = new Date();
      let dd = String(today.getDate()).padStart(2, "0");
      let mm = String(today.getMonth() + 1).padStart(2, "0");
      let yyyy = today.getFullYear();
      this.today = yyyy + "/" + mm + "/" + dd;
      axios
        .post("/api/statistics", {
          apartment_id: this.apartmentId,
          data: this.today,
          visitors: this.userIp,
        })
        .then((res) => {
          res.data.success;
          this.isLoading = false;
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  created() {
    this.apartment = this.$route.params.data;
  },
};
</script>
<style lang="scss" scoped>
.img-container {
  height: 400px;
  width: 100%;
  object-position: center;
  .apartments-img {
    max-width: 100% !important;
    object-fit: cover;
  }
}
#map {
  width: 100%;
  position: relative;
  i {
    position: absolute;
    inset: 0;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2em;
    color: brown;
  }
}
</style>