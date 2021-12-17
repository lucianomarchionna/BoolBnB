<template>
  <section id="cta-host">
    <div class="img-overlay"></div>
    <div class="container h-100">
      <div class="row h-100">
        <div
          class="
            col-12 col-md-9
            cta-host
            d-flex
            flex-column
            align-items-center
            justify-content-center
            text-left
          "
        >
          <div class="text-cta px-3">
            <h2 class="text-white mb-2 title-cta">Prova ad ospitare</h2>
            <h3 class="text-white">
              Condividi il tuo spazio per guadagnare qualcosa in più e cogliere
              nuove opportunità.
            </h3>
          </div>
        </div>
        <div class="col-12 col-md-3 d-flex align-items-center">
          <a
            href="/register"
            class="btn btn-outline-danger bg-danger text-light p-3"
            >Diventa Host</a
          >
        </div>
      </div>
    </div>
  </section>
</template>
<script>
export default {
  name: "CTAhost",
};
</script>
<style lang="scss" scoped>
#cta-host {
  position: relative;
  height: 350px;
  background-image: url("https://images.unsplash.com/photo-1542676032-6e468ada2953?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTd8fHNlYSUyMGhvdXNlfGVufDB8MHwwfHw%3D&auto=format&fit=cropq=60");
  background-position: center;
  background-size: cover;
  background-repeat: no-repeat;
  .cta-host {
    text-shadow: 3px 5px 20px rgba(0, 0, 0, 0.3);

    .title-cta {
      font-size: 3.5em;
      font-weight: 800;
    }
  }

  .img-overlay {
    position: absolute;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.387);
  }
}
</style>