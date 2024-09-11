<template>
  <div>
    <div class="modal fade" id="adjustment-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title modal-title-font" id="exampleModalLabel">{{ title }}</div>
          </div>
          <ValidationObserver v-slot="{ handleSubmit }">
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <p>Requisition ID: {{requisitionId}}</p>
                </div>
                <div class="col-md-12">
                  <p>Advance ID: {{advanceId}}</p>
                </div>
                <div class="col-md-12">
                  <p>Outstanding Before Adjustment: {{prevOutstanding}} Taka</p>
                </div>
              </div>
            </div>
            <form class="form-horizontal" id="form" @submit.prevent="handleSubmit(onSubmit)">
              <div class="modal-body">
                <div class="row">
                  <div class="col-12 col-md-6">
                    <div class="form-group">
                      <label for="name">Expense</label>
                      <input type="number" class="form-control" min="0"
                             name="expense" id="expense" placeholder="0" v-model="expense" @keyup="calculate" @change="calculate">
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="form-group">
                      <label for="name">Refund</label>
                      <input type="number" class="form-control" min="0"
                             name="refund" id="refund" placeholder="0" v-model="refund" @keyup="calculate" @change="calculate" required>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="form-group">
                      <label for="name">Payment</label>
                      <input type="text" class="form-control"
                             name="payment" id="payment" placeholder="0" v-model="payment" disabled>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="form-group">
                      <label for="outstanding">Net Outstanding</label>
                      <input type="number" class="form-control"
                             name="outstanding" id="outstanding" v-model="outstanding" disabled>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="form-group">
                      <label for="refund_type">Refund Type</label>
                      <select class="form-control" id="refund_type" v-model="refundType" required>
                        <option value="">Select</option>
                        <option value="CMR">CMR</option>
                        <option value="TMR">TMR</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="form-group">
                      <label for="reference">Reference</label>
                      <input type="text" class="form-control"
                             name="reference" id="reference" v-model="reference" required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-gradient" id="confirm-button" v-if="buttonShow">{{buttonText}}</button>
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
  data() {
    return {
      title: '',
      requisitionId: '',
      advanceId: '',
      outstanding: '',
      netOutstanding: '',
      outstanding_real: '',
      prevOutstanding: '',
      expense: '',
      refund: '',
      adjustment: '',
      payment: '',
      refundType: '',
      reference: '',
      buttonShow: '',
      buttonText: ''
    }
  },
  computed: {

  },
  created() {
  },
  mounted() {
    $('#adjustment-modal').on('hidden.bs.modal', () => {
      this.$emit('changeStatus')
    });
    bus.$on('edit-adjustment', (row) => {
      let instance = this;
      this.axiosGet('finance/adjustments/get-by-id/'+row.AdjustmentID,function(response){
        let data = response.data;
        instance.title = 'Update Adjustment';
        instance.buttonText = "Update";
        instance.buttonShow = true;
        instance.requisitionId = data.RequisitionID;
        instance.advanceId = data.AdvanceID;
        instance.adjustmentId = data.AdjustmentID;
        instance.outstanding_real = Number(data.Outstanding);
        instance.outstanding = Number(data.Advance) - Number(data.Adjustment);
        instance.prevOutstanding = Number(data.PrevOutstanding);
        instance.adjustment = Number(data.Adjustment);
        instance.prev_adjustment = Number(data.PrevAdjustment);
        instance.expense = Number(data.Expense);
        instance.refund = Number(data.Refund);
        instance.payment = Number(data.Payment);
        instance.refundType = data.RefundType;
        instance.reference = data.RefundRef;
        $("#adjustment-modal").modal("toggle");


        if(Number(data.Refund) ===0){
          console.log("true");
          $('#refund_type').prop('disabled',true)
          $('#reference').prop('disabled',true)
        }
      },function(error){

      });
    })
  },
  destroyed() {
    bus.$off('edit-adjustment')
  },
  methods: {
    calculate() {
      const outValue = () => {
        if (Number(this.expense) > Number(this.prevOutstanding)) {
          return this.outstanding = 0
        } else {
          return this.outstanding = Number(this.prevOutstanding) - Number(this.expense) - Number(this.refund)
        }
      }
      const adjValue = () => {
        if (Number(this.expense) > Number(this.prevOutstanding)) {
          return Number(this.prevOutstanding)
        } else {
          return Number(this.prevOutstanding) + Number(this.expense) + Number(this.refund)
        }
      }
      const payValue = () => {
        if (Number(this.expense) > Number(this.prevOutstanding)) {
          $(`#refund`).prop('disabled',true)
        } else {
          $(`#refund`).prop('disabled',false)
        }
        return Number(this.expense) > Number(this.prevOutstanding) ? Number(this.expense) -  Number(this.prevOutstanding) : 0
      }
      this.outstanding = outValue()
      this.adjustment = adjValue()
      this.payment = payValue()
      //Check Refund Value
      $('#refund_type').prop('disabled',false)
      $('#reference').prop('disabled',false)
      if(this.refund <=0){
        $('#refund_type').prop('disabled',true)
        $('#reference').prop('disabled',true)
        this.refundType= '';
        this.reference ='';
      }
      //Outstanding cannot be negative
      if (this.outstanding < 0) {
        $('#confirm-button').prop('disabled',true)
        this.errorNoti(`Net Outstanding cannot be less than 0 for advance ID ${this.advanceId} !`)
      } else {
        $('#confirm-button').prop('disabled',false)
      }
    },
    onSubmit() {
      if (Number(this.expense) === 0 && Number(this.refund) === 0) {
        this.errorNoti('Expense and Refund Both cannot be 0');
      } else {
        let url = 'adjustments/update';
        this.axiosPost(url, {
          expense: this.expense,
          refund: this.refund,
          adjustmentId: this.adjustmentId,
          refundType: this.refundType,
          reference: this.reference,
        }, (response) => {
          this.successNoti(response.message);
          $("#adjustment-modal").modal("toggle");
          bus.$emit('refresh-datatable');
        }, (error) => {
          this.errorNoti(error);
        })
      }
    }
  }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
