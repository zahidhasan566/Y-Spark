<template>
  <div>
    <div class="modal fade" id="reset_password" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title modal-title-font" id="exampleModalLabel">{{ title }}</div>
          </div>
          <ValidationObserver v-slot="{ handleSubmit }">
            <form class="form-horizontal" id="form" @submit.prevent="handleSubmit(onSubmit)">
              <div class="modal-body">
                <div class="row">
                  <div class="col-12 col-md-6">
                    <ValidationProvider name="New Password" mode="eager" rules="required" v-slot="{ errors }">
                      <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" :class="{'error-border': errors[0]}" id="password" v-model="password" name="password" placeholder="Password">
                        <span class="error-message"> {{ errors[0] }}</span>
                      </div>
                    </ValidationProvider>
                  </div>
                  <div class="col-12 col-md-6">
                    <ValidationProvider name="Confirm Password" mode="eager" rules="required|confirmed:New Password" v-slot="{ errors }">
                      <div class="form-group">
                        <label for="confirm">Confirm Password</label>
                        <input type="password" class="form-control" :class="{'error-border': errors[0]}" id="confirm" v-model="confirm" name="confirm_password" placeholder="Confirm Password">
                        <span class="error-message"> {{ errors[0] }}</span>
                      </div>
                    </ValidationProvider>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <submit-form :name="buttonText"/>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </form>
          </ValidationObserver>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import {bus} from "../../app";
import {Common} from "../../mixins/common";
import {mapGetters} from "vuex";

export default {
  mixins: [Common],
  // components: {Multiselect},
  data() {
    return {
      title: 'Reset Password',
      staffId: '',
      password: '',
      confirm: '',
      buttonText: ''
    }
  },
  mounted() {
    $('#reset_password').on('hidden.bs.modal', () => {
      this.$emit('changeStatus')
    });
    bus.$on('edit-password', (row) => {
      this.title = 'Reset Password';
      this.buttonText = "Reset";
      this.staffId = row;
      this.password = '';
      $("#reset_password").modal("toggle");
    })
  },
  methods: {
    onSubmit() {
      this.$store.commit('submitButtonLoadingStatus', true);
      let url = 'user/reset-password';
      this.axiosPost(url, {
        staffId: this.staffId,
        password: this.password
      }, (response) => {
        this.successNoti(response.message);
        $("#reset_password").modal("toggle");
        bus.$emit('refresh-datatable');
        this.$store.commit('submitButtonLoadingStatus', false);
      }, (error) => {
        this.errorNoti(error);
        this.$store.commit('submitButtonLoadingStatus', false);
      })
    }
  }
}
</script>
