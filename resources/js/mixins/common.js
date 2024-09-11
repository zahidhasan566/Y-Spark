import Swal from 'sweetalert2'

const {format} = require('number-currency-format');
import moment from 'moment'

export const Common = {
    data() {
        return {
            data: {},
        }
    },
    methods: {
        config() {
            let token = localStorage.getItem('token');
            return {
                headers: {Authorization: `Bearer ${token}`}
            };
        },
        axiosGet(route, success, error) {
            axios.get(this.mainOrigin + 'api/' + route, this.config())
                .then((response) => {
                    success(response.data);
                }).catch((err) => {
                if (err.response.status === 401) {
                    localStorage.setItem("token", "");
                    this.redirect(this.mainOrigin + 'login');
                } else {
                    error(err);
                }
            });
        },
        axiosGetWithoutToken(route, success, error) {
            axios.get(this.mainOrigin + 'api/' + route)
                .then((response) => {
                    success(response.data);
                }).catch((err) => {
                error(err);
            });
        },
        axiosPost(route, data, success, error) {
            axios.post(this.mainOrigin + 'api/' + route, data, this.config())
                .then((response) => {
                    success(response.data);
                }).catch((err) => {
                if (err.response.status === 401) {
                    localStorage.setItem("token", "");
                    this.redirect(this.mainOrigin + 'login');
                } else {
                    error(err);
                }
            });
        },
        axiosPostWithoutToken(route, data, success, error) {
            axios.post(this.mainOrigin + 'api/' + route, data)
                .then((response) => {
                    success(response.data);
                }).catch((err) => {
                error(err);
            });
        },
        axiosDelete(route, id, success, error) {
            axios.delete(this.mainOrigin + 'api/' + route + '/' + id, this.config())
                .then((response) => {
                    success(response.data);
                }).catch((err) => {
                if (err.response.status === 401) {
                    localStorage.setItem("token", "");
                    this.redirect(this.mainOrigin + 'login');
                } else {
                    error(err);
                }
            });
        },
        axiosPut(route, data, success, error) {
            axios.put(this.mainOrigin + 'api/' + route, data, this.config())
                .then((response) => {
                    success(response.data);
                }).catch((err) => {
                if (err.response.status === 401) {
                    localStorage.setItem("token", "");
                    this.redirect(this.mainOrigin + 'login');
                } else {
                    error(err);
                }
            });
        },
        redirect(route) {
            window.location.href = route;
        },
        successNoti(msg) {
            this.$toaster.success(msg)
        },
        errorNoti(msg) {
            if (msg.response === undefined) {
                this.$toaster.error(msg);
            } else if (msg.response.data.message === undefined) {
                this.$toaster.error(msg);
            } else {
                this.$toaster.error(msg.response.data.message);
            }
        },
        numberFormat(value) {
            if (value == null) {
                return '';
            } else {
                return format(value, {
                    currency: '',
                    spacing: false,
                    currencyPosition: 'LEFT'
                });
            }
        },
        weightFormat(value) {
            return format(value, {
                currency: ' Kg.',
                spacing: false,
                currencyPosition: 'right'
            })
        },
        dateFormat(date) {
            return date ? moment(date, 'YYYY-MM-DD').format("DD-MM-YYYY") : '';
        },
        dateTimeFormat(date) {
            return date ? moment(date, 'YYYY-MM-DD h:mm:ss').format("DD-MM-YYYY h:mm a") : '';

        },
        periodFormat(data) {
            return data ? moment(data).format('MM-YYYY') : ''
        },
        deleteAlert(callback) {
            Swal.fire({
                title: 'Are you sure to cancel?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Cancel it!',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {
                    callback();
                }
            })
        },
        infoAlert(title, message) {
            Swal.fire({
                title: title,
                text: message,
                icon: 'info',
                showCancelButton: true,
                showConfirmButton: false,
                cancelButtonColor: '#d33',
                cancelButtonText: 'Close',
            })
        },
        processText(value) {
            let rex = /([A-Z])([A-Z])([a-z])|([a-z])([A-Z])/g;
            value = value.replace(rex, '$1$4 $2$3$5');
            value = value.replace('-', ' ');
            return value;
        },
        numberWithCommas(x) {
            if (x !== undefined) {
                x = Number(x)
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        },
    },
}
