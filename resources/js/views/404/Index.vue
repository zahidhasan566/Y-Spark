<template>
  <div class="ex-pages">
    <div class="content-center">
      <div class="content-desc-center">
        <div class="container">
          <div class="card mo-mt-2">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-lg-4 offset-lg-1">
                  <div class="ex-page-content"><h1 class="text-dark">404!</h1><h4 class="mb-4">Sorry, page not
                    found</h4>
                    <p class="mb-5">It will be as simple as Occidental in fact, it will be Occidental to an English
                      person</p>
                    <router-link class="btn btn-primary mb-5 waves-effect waves-light" :to="`${mainOrigin}dashboard`"><i
                        class="mdi mdi-home"></i> Back to Dashboard
                    </router-link>
                  </div>
                </div>
                <div class="col-lg-5 offset-lg-1"><img :src="`${mainOrigin}assets/images/error.png`" alt=""
                                                       class="img-fluid mx-auto d-block"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
