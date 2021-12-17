<template>
  <div>
    <div class="container my-3 py-3">
      <div class="form-group">
        <input
          type="text"
          v-model="city"
          @keyup.enter="getApartments"
          placeholder="Città"
          class="form-control"
        />
        <button
          class="btn btn-danger my-3"
          @click="getApartments"
          id="getCityBtn"
        >
          Vai
        </button>
      </div>
      <template>
        <div v-if="citySearched">
          <div class="form-services row">
            <div
              class="form-group col-2"
              v-for="service in services"
              :key="service.id"
            >
              <label class="my_btns btn btn-outline-dark" :for="service.id"
                ><i :class="service.icon"></i
              ></label>
              <input
                type="checkbox"
                :name="service.name"
                :id="service.id"
                class=""
                :value="service.id"
                @change="getSelectedServices"
              />
            </div>
          </div>
          <div class="form-group">
            <input
              class="form-control"
              type="number"
              v-model="guests"
              placeholder="Numero ospiti"
              @change="getApartments"
            />
          </div>
          <div class="form-group">
            <input
              class="form-control"
              type="number"
              v-model="rooms"
              placeholder="Numero stanze"
              @change="getApartments"
            />
          </div>
          <div class="form-group">
            <label class="" for="rangeDistance">Raggio: {{ distance }}Km</label>
            <input
              class="form-control"
              type="range"
              v-model="distance"
              placeholder="Distanza"
              @change="getApartments"
              max="40"
              id="rangeDistance"
            />
          </div>
        </div>
      </template>
    </div>
    <section class="container mb-5">
      <div class="row justify-content-around mx-0">
        <div class="col-12 my-3">
          <h3 v-if="resultCity != ''">
            Risultati trovati per :
            <span class="font-weight-bold text-capitalize">
              {{ resultCity }}</span
            >
            ({{ apartments.length }})
          </h3>
          <h3 v-else><strong>Viaggetto a Roma?</strong></h3>
        </div>
        <div class="col-12 col-md-6">
          <div
            class="row"
            v-for="(apartment, index) in apartments"
            :key="index"
          >
            <div class="col-12">
              <router-link
                class="text-decoration-none"
                :to="{
                  name: 'Dettaglio | BoolBnB',
                  params: { slug: apartment.slug },
                }"
                style="color: inherit"
              >
                <div class="card mb-3 border-0" style="max-width: 540px">
                  <div class="row no-gutters">
                    <div class="col-md-4">
                      <img
                        :src="'/storage/' + apartment.image"
                        class="card-img-top"
                        alt=""
                      />
                    </div>
                    <div class="col-md-8">
                      <div class="card-body">
                        <h5 class="card-title font-weight-bold">
                          {{ apartment.title }}
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                          {{ apartment.city }}
                        </h6>
                        <p class="card-text text-truncate">
                          {{ apartment.description }}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </router-link>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="container-map">
            <div id="map_div" class="map"></div>
          </div>
        </div>
      </div>
    </section>
    <CTAhost />
  </div>
</template>
<script>
import CTAhost from "../components/CTAhost.vue";

export default {
  name: "Main",
  components: {
    CTAhost,
  },
  props: ["destination"],
  data() {
    return {
      distance: "20", // Inizializzo con 20 come richiesto dal Brief
      rooms: "",
      guests: "",
      myUrl: "/api/apartments",
      tomTomAPI: "https://api.tomtom.com/search/2/geocode/",
      city: this.$route.params.destination,
      resultCity: "",
      apiKey: ".json?key=6pyK2YdKNiLrHrARYvnllho6iAdjMPex",
      API_KEY: "6pyK2YdKNiLrHrARYvnllho6iAdjMPex",
      apartments: [],
      lat: "41.89193",
      long: "12.51133",
      citySearched: false,
      services: [],
      selectedServices: [],
      map: undefined,
      apartmentID: "",
      today: "",
      isLoading: true,
      popupOffsets: {
        top: [0, 0],
        bottom: [0, -70],
        left: [25, -35],
        right: [-25, -35],
      },
    };
  },
  methods: {
    async getServices() {
      let resServices = await axios.get(this.myUrl);
      this.services = resServices.data.services;
    },
    async getApartments() {
      if (this.city) {
        await axios
          .get(this.tomTomAPI + this.city + this.apiKey)
          .then((res) => {
            this.lat = res.data.results[0].position.lat;
            this.long = res.data.results[0].position.lon;
            this.resultCity = this.city;
            this.citySearched = true;
          });
      }
      axios
        .get(
          this.myUrl +
            "?n_guests=" +
            this.guests +
            "&n_rooms=" +
            this.rooms +
            "&n_baths=" +
            this.rooms +
            "&distance=" +
            this.distance +
            "&lat=" +
            this.lat +
            "&long=" +
            this.long +
            "&services=" +
            this.selectedServices
        )
        .then((res) => {
          this.apartments = res.data.results;
          this.createMarker(this.apartments);
          // this.isLoading = false;
        });
      if (this.map != undefined) {
        this.getMap();
      }
    },
    getSelectedServices(el) {
      if (el.target.checked === true) {
        this.selectedServices.push(el.target.value);
      } else {
        this.selectedServices.splice(
          this.selectedServices.indexOf(el.target.value),
          1
        );
      }
      this.getApartments();
    },
    getMap() {
      this.map = tt.map({
        container: "map_div",
        key: this.API_KEY,
        source: "vector",
        center: [this.long, this.lat],
        zoom: 14,
      });
      this.map.addControl(new tt.FullscreenControl());
      this.map.addControl(new tt.NavigationControl());
    },
    createMarker(arr) {
      arr.forEach((element) => {
        let cor = [element.long, element.lat];
        let marker = new tt.Marker().setLngLat(cor).addTo(this.map);
        let popup = new tt.Popup({ offset: this.popupOffsets }).setHTML(
          `<div class="card-body p-1">
              <h5 class="card-title">${element.title}</h5>
              <h6 class="card-subtitle mb-2 text-muted">
                ${element.type}
              </h6>
              <p class="card-text">${element.street}</p>
            </div>`
        );
        marker.setPopup(popup);
      });
    },
  },
  created() {
    this.getApartments();
    this.getServices();
  },
  mounted() {
    this.getMap();
  },
};
</script>

<style lang="scss" scoped>
.card-img-top {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.marker-icon {
  background-position: center;
  background-size: 22px 22px;
  border-radius: 50%;
  height: 22px;
  left: 4px;
  position: absolute;
  text-align: center;
  top: 3px;
  transform: rotate(45deg);
  width: 22px;
}
.marker {
  height: 30px;
  width: 30px;
}
.marker-content {
  background: #c30b82;
  border-radius: 50% 50% 50% 0;
  height: 30px;
  left: 50%;
  margin: -15px 0 0 -15px;
  position: absolute;
  top: 50%;
  transform: rotate(-45deg);
  width: 30px;
}
.marker-content::before {
  background: #ffffff;
  border-radius: 50%;
  content: "";
  height: 24px;
  margin: 3px 0 0 3px;
  position: absolute;
  width: 24px;
}

.container-map {
  height: 100%;
  min-height: 350px;
  #map_div {
    height: 100%;
    overflow: hidden;
  }
}

.my_btns {
  padding: 15px;
  border: none;
  transition: box-shadow 0.4s ease;
  font-size: 20px;
}

#rangeDistance,
input[type="checkbox"] {
  accent-color: #ff385c;
}

input[type="checkbox"] {
  width: 20px;
  aspect-ratio: 1;
}
</style>