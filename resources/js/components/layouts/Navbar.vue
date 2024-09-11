<template>
    <div class="topbar">
        <!-- LOGO -->
        <div class="topbar-left">
            <a href="index.html" class="logo">
                <span style="color: white">ACI E SHRIMP</span><i>ACI E SHRIMP</i>
            </a>
        </div>
        <nav class="navbar-custom">
            <ul class="navbar-right list-inline float-right mb-0">
                <!-- full screen -->
                <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
                    <a class="nav-link waves-effect" href="#" id="btn-fullscreen"><i class="mdi mdi-fullscreen noti-icon"></i></a>
                </li>

                <!-- notification -->
                <li class="dropdown notification-list list-inline-item">
                    <div class="dropdown notification-list nav-pro-img">
                        <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="assets/images/users/user-4.jpg" alt="user" class="rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                            <!-- item-->
                            <button @click="openUserModel" class="dropdown-item" title="profile"> <i class="mdi mdi-account-circle m-r-5"></i>  Profile</button>

                        </div>
                    </div>
                </li>

                <li  class="notification-list list-inline-item">
                    <div class="nav-link waves-effect" style="padding: 0">
                        <p class="pad-cus-badge badge badge-primary">{{me.roles ? me.roles.RoleName:''}}</p>
                    </div>

                </li>
                <li class="notification-list list-inline-item">
                    <div class="nav-link waves-effect" style="padding: 0">
                        <button @click="logout" title="Logout" type="button" class="btn"><i class="ti-power-off"></i></button>
                    </div>
                </li>
            </ul>
            <ul class="list-inline menu-left mb-0">
                <li class="float-left">
                    <button class="button-menu-mobile open-left waves-effect"><i class="mdi mdi-menu"></i></button>
                </li>
            </ul>

        </nav>
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
                                                <input type="text" class="form-control"  v-model="me.Id" readonly/>
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
<script >
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
    computed: {
        me() {
            return this.$store.state.me

        }
    },
    methods: {
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
