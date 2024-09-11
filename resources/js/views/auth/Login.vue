<template>
  <div class="loginBody">
<!--      :style="{ backgroundImage: `url(${BackgroundImage})` }"-->
    <div class="wrapper-page">
      <div class="card loginBg overflow-hidden account-card mx-3">
        <div class="bg-gradient p-4 text-white text-center position-relative">
          <h4 class="font-25 m-b-5"> WELCOME TO ACI E SHRIMP </h4>
        </div>
        <div class="account-card-content">
          <ValidationObserver v-slot="{ handleSubmit }">
            <form class="form-horizontal m-t-30" @submit.prevent="handleSubmit(onSubmit)">
              <ValidationProvider name="User ID" mode="eager" rules="required" v-slot="{ errors }">
                <div class="form-group">
                  <label for="username" style="color: white">User Email Or Phone</label>
                  <input type="text" class="form-control" :class="{'error-border': errors[0]}" id="usermailorphone"
                         v-model="usermailorphone" name="usermailorphone" placeholder="User Mail Or Mobile" autocomplete="off">
                  <span class="error-message" style="background: white"> {{ errors[0] }}</span>
                </div>
              </ValidationProvider>
              <ValidationProvider name="Password" mode="eager" rules="required|min:6" v-slot="{ errors }">
                <div class="form-group">
                  <label style="color: white" for="user-password">Password</label>
                  <input type="password" v-model="password" class="form-control" :class="{'error-border': errors[0]}"
                         id="user-password" placeholder="Password" autocomplete>
                  <span class="error-message" style="background: white">{{ errors[0] }}</span>
                </div>
              </ValidationProvider>
              <submit-form name="Log In"/>
            </form>
          </ValidationObserver>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import {Common} from '../../mixins/common'
import moment from "moment";
import {baseurl} from "../../base_url";


export default {
  mixins: [Common,baseurl],
  data() {
    return {
      usermailorphone: '',
      password: '',
      MenuBaseUrl:'',
      BackgroundImage:''
    }
  },
  computed: {
    now() {
      return moment()
    }
  },
  mounted() {
      this.BackgroundImage = window.location.origin + baseurl +  '/public/assets/shrimp/shrimp2.jpg'
      console.log(window.location.origin + baseurl)
      // this.getData();
  },
  methods: {
    onSubmit() {
      this.$store.commit('submitButtonLoadingStatus', true);
      this.axiosPostWithoutToken('login', {
        usermailorphone: this.usermailorphone,
        password: this.password
      }, (response) => {
          console.log(response)
        localStorage.setItem("token", response.access_token);
        this.successNoti('Successfully logged in.');
        this.$store.commit('submitButtonLoadingStatus', false);
        this.redirect(this.mainOrigin + 'dashboard')
      }, (error) => {
        this.errorNoti(error);
        this.$store.commit('submitButtonLoadingStatus', false);
      })
    }
  }
}
</script>
<style>
.loginBody {
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    background-image: url(http://localhost/aci_e_shrimp/public/assets/shrimp/orangeshirmp.jpg) !important;
    min-height: 100VH;
    position: absolute;
    width: 100%;
    top: 0;
}
 .loginBg{
     /*backdrop-filter: blur(8px);*/
     box-shadow: 0px 10px 15px 10px rgba(0, 0, 0, 0.15);
     background-color: rgba(228, 228, 228, 0.30);
 }
</style>
