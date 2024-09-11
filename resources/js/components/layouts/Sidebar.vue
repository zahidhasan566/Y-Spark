<template>
  <div class="topnav">
    <div class="container-fluid">
      <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
        <div class="collapse navbar-collapse" id="topnav-menu-content">
          <ul class="navbar-nav active">
            <li class="nav-item dropdown" v-for="(menu,index) in menus" :key="index">
              <router-link :to="`/AMS/${menu.MenuLink}`" class="nav-link" :id="`area${index}`" role="button">
                <i :class="menu.MenuIcon"></i>
                <span>
                {{ menu.MenuName }}
                <span v-if="menu.sub_menus.length > 0" class="float-right menu-arrow"><i
                    class="mdi mdi-chevron-right"></i></span>
              </span>
              </router-link>
              <div class="dropdown-menu" v-if="menu.sub_menus.length > 0" :aria-labelledby="`area${index}`">
                <router-link class="dropdown-item" v-for="(subMenu,index2) in menu.sub_menus" :key="index2"
                             :to="`/AMS/${subMenu.SubMenuLink}`">
                  <span>{{ subMenu.SubMenuName }}</span>
                </router-link>
              </div>
            </li>
          </ul>
        </div>
        <p class="pad-cus"><b>{{me.StaffName}}</b></p>
        <button @click="openUserModel" title="profile" style="margin: 0px 3px" class="logout"><i class="ti-user"></i></button>
        <p class="pad-cus-badge badge badge-primary">{{me.roles ? me.roles.RoleName:''}}</p>
        <button @click="logout" title="Logout" class="logout"><i class="ti-power-off"></i></button>
      </nav>
    </div>
    <div v-if="myModel">
      <transition name="model">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"> Update Profile</h4>
                  <button type="button"  @click="myModel=false" class="close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>User Id</label>
                        <input type="text" class="form-control"  v-model="me.UserId" readonly/>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" v-model="me.Email" readonly/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" style="margin:0">
                    <label>Password</label>
                    <input type="password" class="form-control" v-model="updatePassword"/>
                  </div>
                  <div class="form-group" style="margin:0">
                    <label> Confirm Password</label>
                    <input type="password" class="form-control" v-model="confirmUpdatePassword"/>
                  </div>
                  <br />
                  <div align="center">
                    <button class="btn btn-primary" @click="updateUserModel"> Update</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
  </div>
</template>
<script>
import {Common} from "../../mixins/common";
import {baseurl} from "../../base_url";
import {bus} from "../../app";

export default {
  mixins: [Common, baseurl],
  data() {
    return {
      menus: [],
      authUser: {},
      myModel:false,
      updatePassword:'',
      confirmUpdatePassword: '',
    }
  },
  mounted() {
    this.getData();
  },
  computed: {
    me() {
      return this.$store.state.me
    }
  },
  methods: {
    getData() {
      this.axiosGet('app-supporting-data', (response) => {
        this.menus = response.menus;
        this.$store.commit('me', response.user);
        this.$store.commit('particulars', response.particulars);
        setTimeout(() => {
          $("#side-menu").metisMenu();
        })
      }, (error) => {
        this.errorNoti(error)
      })
    },
    logout() {
      this.axiosPost("logout", {}, (response) => {
            localStorage.setItem("token", "");
            this.$router.push(this.mainOrigin + "login");
            this.successNoti(response.message)
          },
          (error) => {
            this.errorNoti(error);
          }
      );
    },
    openUserModel(){
      this.myModel = true;
    },
    //Update User Password
    updateUserModel(){
      let url = 'user/password-change';
      this.axiosPost(url, {
        UserId: this.me.Id,
        updatePassword: this.updatePassword,
        confirmUpdatePassword: this.confirmUpdatePassword,
      }, (response) => {
        this.successNoti(response.message);
        this.myModel = false;
      }, (error) => {
        this.errorNoti(error);
      })
    }
  }
}
</script>

<style scoped>
.topnav {
  margin-top: 0;
}

.pad-cus {
  padding: 5px 20px;
  color: #ffffff;
  margin: 0 15px;
  font-size: 10px;
  border-radius: 5px;
  border: 1px solid #ffffff;
}

.pad-cus-badge {
  padding: 10px 20px;
  margin: 0 10px 0 0;
  font-weight: bold;
  letter-spacing: 0.09em;
}

.logout {
  border-radius: 5px;
  margin-left: 5px;
  border: 1px solid #33354773;
  background: #3335473d;
  color: #ffffff;
  font-size: 17px;
  letter-spacing: 0.09em;
}
 .modal-mask {
   position: fixed;
   z-index: 9998;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   background-color: rgba(0, 0, 0, .5);
   display: table;
   transition: opacity .3s ease;
 }

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}
</style>
