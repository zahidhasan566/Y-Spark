<template>
    <div id="wrapper">
        <Navbar/>
        <LeftSidebar/>
        <div class="content-page">
          <div class="content">
              <div class="container-fluid">
                  <router-view></router-view>
                  <Footer/>
              </div>
          </div>
        </div>
    </div>
</template>
<script>
import Sidebar from './Sidebar'
import Footer from './Footer'
import Navbar from "./Navbar.vue";
import LeftSidebar from "./LeftSidebar.vue";

export default {
    components: {
        LeftSidebar,
        Navbar,
        Sidebar,
        Footer
    }
}
</script>
