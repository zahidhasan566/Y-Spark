<template>
  <div class="modal fade" id="change-delivery-status" tabindex="-1" aria-labelledby="exampleModalLabel"
       aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title modal-title-font" id="exampleModalLabel">Change Delivery Status</div>
        </div>
        <ValidationObserver v-slot="{ handleSubmit }">
          <form class="form-horizontal" id="form" @submit.prevent="handleSubmit(changeStatus)">
            <div class="modal-body">
              <ul class="message-list">
                <li>
                  <div class="col-mail">Customer Name :</div>
                  <div class="date">{{ delivery.CustomerName }}</div>
                </li>
                <li>
                  <div class="col-mail">Customer Mobile :</div>
                  <div class="date">{{ delivery.CustomerMobile }}</div>
                </li>
                <li>
                  <div class="col-mail">Delivery Address :</div>
                  <div class="date">{{ delivery.DeliveryAddress }}</div>
                </li>
                <li>
                  <div class="col-mail">Invoice Number :</div>
                  <div class="date">{{ delivery.InvoiceID }}</div>
                </li>
                <li>
                  <div class="col-mail">Status :</div>
                  <div class="date">
                    <select class="form-control" id="status"
                            v-model="statusId" name="status">
                      <option v-for="(item,index) in status" :key="index" :value="item.StatusID" :disabled="item.StatusID==1 && me.UserType=='rider'">
                        {{ item.Status }}
                      </option>
                    </select>
                  </div>
                </li>
              </ul>
            </div>
            <div class="modal-footer">
              <submit-form name="Change Status"/>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </form>
        </ValidationObserver>
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
  data() {
    return {
      title: '',
      statusId: '',
      delivery: {}
    }
  },
  computed: {
    ...mapGetters(['status','me']),
  },
  mounted() {
    bus.$on('change-delivery-status', (row) => {
      this.delivery = row;
      this.statusId = row.StatusID;
      $("#change-delivery-status").modal("toggle");
    })
  },
  methods: {
    changeStatus() {
      this.$store.commit('submitButtonLoadingStatus', true);
      this.axiosPost('update_delivery_status', {
        DeliveryID: this.delivery.DeliveryID,
        StatusID: this.statusId,
      }, (response) => {
        this.successNoti(response.message);
        $("#change-delivery-status").modal("toggle");
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
<style lang="scss" scoped>
.col-mail {
  width: 130px !important;
}

.message-list li {
  height: 30px !important;
  line-height: unset !important;
}

.form-control {
  width: unset !important;
}
</style>
