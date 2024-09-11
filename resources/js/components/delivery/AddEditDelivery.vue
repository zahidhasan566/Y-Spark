<template>
  <div>
    <div class="modal fade" id="add-edit-dept" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <ValidationProvider name="Customer Mobile" mode="eager" rules="required|min:11"
                                        v-slot="{ errors }">
                      <div class="form-group">
                        <label for="customer-mobile">Customer Mobile</label>
                        <input type="text" class="form-control" :class="{'error-border': errors[0]}"
                               id="customer-mobile"
                               v-model="customerMobile" @keyup="getCustomerDetails" name="customer-mobile"
                               placeholder="Customer mobile">
                        <span class="error-message"> {{ errors[0] }}</span>
                      </div>
                    </ValidationProvider>
                  </div>
                  <div class="col-12 col-md-6">
                    <ValidationProvider name="Customer Name" mode="eager" rules="required" v-slot="{ errors }">
                      <div class="form-group">
                        <label for="customer-name">Customer Name</label>
                        <input type="text" class="form-control" :class="{'error-border': errors[0]}" id="customer-name"
                               v-model="customerName" name="customer-name" placeholder="Customer name"
                               :disabled="isDisabled">
                        <span class="error-message"> {{ errors[0] }}</span>
                      </div>
                    </ValidationProvider>
                  </div>
                  <div class="col-12 col-md-6">
                    <ValidationProvider name="Customer Address" mode="eager" rules="required" v-slot="{ errors }">
                      <div class="form-group">
                        <label for="customer-address">Customer Address</label>
                        <input type="text" class="form-control" :class="{'error-border': errors[0]}"
                               id="customer-address"
                               v-model="customerAddress" name="customer-address" placeholder="Customer address"
                               :disabled="isDisabled">
                        <span class="error-message"> {{ errors[0] }}</span>
                      </div>
                    </ValidationProvider>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="ml-1 mb-1 custom-control checkbox custom-control-inline">
                      <input type="checkbox" id="check-address" class="custom-control-input"
                             @click="manipulateDeliveryAddress">
                      <label class="custom-control-label group-tree" for="check-address">Delivery address (same as
                        customer address)</label>
                    </div>
                    <ValidationProvider name="Delivery Address" mode="eager" rules="required" v-slot="{ errors }">
                      <div class="form-group">
                        <input type="text" class="form-control" :class="{'error-border': errors[0]}"
                               id="delivery-address"
                               v-model="deliveryAddress" name="delivery-address" placeholder="Delivery address">
                        <span class="error-message"> {{ errors[0] }}</span>
                      </div>
                    </ValidationProvider>
                  </div>
                  <div class="col-12 col-md-6">
                    <ValidationProvider name="Invoice Number" mode="eager" rules="required|min:4|max:4"
                                        v-slot="{ errors }">
                      <div class="form-group">
                        <label for="invoice-number">Invoice Number</label>
                        <div class="input-group">
                          <span class="input-group-text" id="basic-addon1">{{ invoicePrefix }}</span>
                          <input type="number" class="form-control" :class="{'error-border': errors[0]}"
                                 id="invoice-number"
                                 v-model="invoiceNumber" name="invoice-number" placeholder="Invoice Number"
                                 aria-describedby="basic-addon1">
                          <span class="error-message"> {{ errors[0] }}</span>
                        </div>
                      </div>
                    </ValidationProvider>
                  </div>
                  <div class="col-12 col-md-6">
                    <ValidationProvider name="Order Amount" mode="eager" rules="required" v-slot="{ errors }">
                      <div class="form-group">
                        <label for="invoice-number">Order Amount</label>
                        <input type="text" class="form-control" :class="{'error-border': errors[0]}" id="order-amount"
                               v-model="amount" name="order-amount" placeholder="Order Amount">
                        <span class="error-message"> {{ errors[0] }}</span>
                      </div>
                    </ValidationProvider>
                  </div>
                  <div class="col-12 col-md-6">
                    <ValidationProvider name="Rider" mode="eager" rules="required" v-slot="{ errors }">
                      <div class="form-group">
                        <label for="rider">Select Rider</label>
                        <select class="form-control" :class="{'error-border': errors[0]}" id="rider"
                                v-model="riderId" name="rider">
                          <option v-for="(rider,index) in riders" :key="index" :value="rider.UserId">
                            {{ rider.UserName }}
                          </option>
                        </select>
                        <span class="error-message"> {{ errors[0] }}</span>
                      </div>
                    </ValidationProvider>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="form-group">
                      <label for="invoice-number">Special Notes</label>
                      <input type="text" class="form-control" id="special-notes"
                             v-model="specialNotes" name="special-notes" placeholder="Special notes">
                    </div>
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
import moment from 'moment';

export default {
  mixins: [Common],
  data() {
    return {
      title: '',
      customerName: '',
      customerMobile: '',
      customerAddress: '',
      deliveryAddress: '',
      invoiceNumber: '',
      buttonText: "",
      riderId: '',
      specialNotes: '',
      deliveryId: '',
      amount: '',
      invoicePrefix: '',
      isDisabled: false,
      customerId: ''
    }
  },
  computed: {
    ...mapGetters(['riders', 'me']),
    // invoicePrefix: () => {
    //   return moment().format('YYYY-MM-DD');
    // }
  },
  mounted() {
    this.invoicePrefix = this.me.OutletCode + moment().format('YYYYMMDD');
    $('#add-edit-dept').on('hidden.bs.modal', () => {
      this.$emit('changeStatus')
    });
    bus.$on('add-edit-delivery', () => {
      this.title = 'Add Delivery';
      this.buttonText = "Add";
      $("#add-edit-dept").modal("toggle");
    })
  },
  methods: {
    resetCustomer() {
      this.customerName = '';
      this.customerAddress = '';
      this.customerId = ''
      this.isDisabled = false
    },
    getCustomerDetails(event) {
      let value = event.target.value;
      if (value.length >= 11) {
        this.axiosGet('get_customer_by_phone/' + value,
            (response) => {
              let customer = response.customer;
              if (customer) {
                this.customerName = customer.CustomerName;
                this.customerAddress = customer.CustomerAddress;
                this.customerId = customer.CustomerID
                this.isDisabled = true
              } else {
                this.resetCustomer()
              }
            }, (error) => {
              this.resetCustomer()
              this.errorNoti(error)
            })
      }
    },
    manipulateDeliveryAddress() {
      if ($("#check-address").is(":checked")) this.deliveryAddress = this.customerAddress;
      else this.deliveryAddress = '';
    },
    onSubmit() {
      this.$store.commit('submitButtonLoadingStatus', true);
      this.axiosPost('make_delivery', {
        InvoiceID: this.invoicePrefix + this.invoiceNumber,
        DeliveryAddress: this.deliveryAddress,
        CustomerName: this.customerName,
        CustomerPhone: this.customerMobile,
        CustomerAddress: this.customerAddress,
        SpecialInstruction: this.specialNotes,
        RiderID: this.riderId,
        StatusID: 1,
        Amount: this.amount,
        CustomerID: this.customerId
      }, (response) => {
        this.successNoti(response.data.message);
        $("#add-edit-dept").modal("toggle");
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
