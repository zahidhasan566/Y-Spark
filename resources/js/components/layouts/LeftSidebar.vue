<template>
    <div class="left side-menu">
        <div class="slimscroll-menu" id="remove-scroll">
            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu" id="side-menu">
                    <li class="menu-title">Main</li>
                    <li v-for="(menu,index) in menus" :key="index" v-if="(menu.sub_menus.length >=1 && me.RoleID !=='SuperAdmin') || (menu.sub_menus.length >=0 && me.RoleID ==='SuperAdmin' )">
                        <router-link :to="`${MenuBaseUrl}${menu.MenuLink}`" class="waves-effect" :id="`area${index}`">
                            <i :class="menu.MenuIcon"></i>
                            <span>  {{ menu.MenuName }}
                                <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span></span>
                        </router-link>
                        <ul class="submenu" v-if="menu.sub_menus.length > 0" :aria-labelledby="`area${index}`">
                            <li>
                                <router-link  v-for="(subMenu,index2) in menu.sub_menus" :key="index2" :to="`${MenuBaseUrl}${subMenu.SubMenuLink}`">
                                    <i class="ti-control-forward"></i> {{ subMenu.SubMenuName }}
                                </router-link>


                            </li>

                        </ul>
                    </li>
                </ul>
            </div>
            <!-- Sidebar -->
            <div class="clearfix"></div>
        </div>
        <!-- Sidebar -left -->
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
            MenuBaseUrl:''
        }
    },
    mounted() {
        this.MenuBaseUrl = baseurl
        this.getData();
    },
    // created() {
    //     setTimeout(() => {
    //         $("#side-menu").metisMenu();
    //     })
    // },
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
                UserId: this.me.UserId,
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
