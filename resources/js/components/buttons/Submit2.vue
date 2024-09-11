<template>
  <div class="form-group row mb-0" >
    <div class="col-sm-12">
      <button  class="submit-button btn btn-primary btn-sm w-md waves-effect waves-light" :disabled="$store.state.isSubmitButtonLoading">
        <span v-if="!$store.state.isSubmitButtonLoading">{{ name }}</span>
        <span v-else> <img  :src="`${mainOrigin}assets/images/loaders/mini.svg`" alt="min loader"> Waiting</span>
      </button>
    </div>
  </div>
</template>
<script>
export default {
  props: ['name']
}
</script>
