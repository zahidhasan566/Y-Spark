<template>
  <div class="page-title-box">
    <div class="row align-items-center">
      <div class="col-sm-6">
        <h4 class="page-title">{{ options[options.length - 1] }}</h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <router-link :to="{name:'Dashboard'}">Home</router-link>
          </li>
          <li class="breadcrumb-item" :class="{active:index === options.length-1}"
              v-for="(option,index) in options" :key="index">{{ option }}
          </li>
        </ol>
      </div>
      <div class="col-sm-6">
        <div class="float-right">
          <slot></slot>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ['options']
}
</script>

<style scoped>
.page-title-box {
  padding:10px 2px !important;
}
.page-title-box .page-title {
  font-size: 13px !important;
}
</style>
