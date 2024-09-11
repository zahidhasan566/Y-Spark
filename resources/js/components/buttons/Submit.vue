<template>
    <div class="form-group row mb-0" >
        <div class="col-sm-12 text-right">
            <button  class="btn btn-primary" :disabled="$store.state.isSubmitButtonLoading">
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
