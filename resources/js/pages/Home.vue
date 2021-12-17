<template>
  <section>
    <Jumbotron />
    <Sponsored />
    <CTAhost />
    <Places />
  </section>
</template>
<script>
import Jumbotron from "../components/Jumbotron.vue";
import Sponsored from "../components/Sponsored.vue";
import CTAhost from "../components/CTAhost.vue";
import Places from "../components/Places.vue";
export default {
  name: "Home",
  components: {
    Jumbotron,
    Sponsored,
    CTAhost,
    Places,
  },
  data() {
    return {};
  },
  methods: {},
};
</script>
<style lang="scss" scoped>
</style>