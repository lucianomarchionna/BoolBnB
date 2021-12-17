<template>
  <div class="container">
    <h4 class="my-2">Sei interessato a prenotare?</h4>
    <h1 class="mt-4">Contatta l'host</h1>
    <form
      class="mb-4"
      @submit.prevent="sendMessage"
      action="mail.php"
      method="POST"
    >
      <div class="d-flex">
        <div class="form-group w-50 mr-3 my-3">
          <label for="fullname">Nome e Cognome:</label>
          <input
            class="w-100"
            type="text"
            v-model="username"
            name="fullname"
            id="fullname"
          />
        </div>

        <div class="form-group w-50 ml-3 my-3">
          <label for="email">Email:</label>
          <input
            class="w-100"
            type="email"
            v-model="email"
            name="email"
            id="email"
          />
        </div>
      </div>

      <div class="form-group">
        <label for="message">Messaggio:</label>
        <textarea
          class="w-100"
          type="textarea"
          v-model="message"
          id="message"
          placeholder="Chiedi al proprietario tutte le info di cui hai bisogno..."
        ></textarea>
      </div>
      <div class="d-flex justify-content-end ">
        <button class="btn btn-login-register p-2" type="submit">
          Invia Messaggio
        </button>
      </div>
      <div
        class="my-3 alert alert-success alert-dismissible fade show"
        v-if="messageSent"
        role="alert"
      >
        Il messaggio è stato inviato con successo!
        <button
          type="button"
          class="close"
          data-dismiss="alert"
          aria-label="Close"
        >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    </form>
  </div>
</template>
<script>
export default {
  name: "ContactForm",
  props: ["apartment"],
  data() {
    return {
      email: "",

      errors: {},
      messageSent: false,
      user: "",
      username: "",
      message: "",
    };
  },
  mounted() {
    this.isLogged();
  },
  methods: {
    isLogged() {
      axios.get("/api/user").then((res) => {
        this.username = res.data.user.name;
        this.email = res.data.user.email;
      });
    },
    sendMessage() {
      axios
        .post("/api/contacts", {
          email: this.email,
          fullname: this.username,
          apartment_id: this.apartment.id,
          apartment_title: this.apartment.title,
          message: this.message,
        })
        .then((res) => {
          this.messageSent = res.data.success;
          this.email = "";
          this.message = "";
        })
        .catch((err) => {
          console.log(err);
        })
        .finally(() => {
          this.isLogged;
        });
    },
  },
};
</script>

<style lang="scss" scoped>
</style>