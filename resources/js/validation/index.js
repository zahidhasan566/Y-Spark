import Vue from 'vue'
import {baseurl} from '../base_url'

import {extend, ValidationObserver, ValidationProvider} from 'vee-validate/dist/vee-validate.full'

Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);

const config = () => {
    let token = localStorage.getItem('token');
    return {
        headers: {Authorization: `Bearer ${token}`}
    };
}

extend('checkunique', {
    async validate(value, {api}) {
        console.log(baseurl)
        await axios.post(baseurl + 'api/' + api, {
            value
        }, config()).then((response) => {
            // if (!response.data.status){
            //     console.log(response.data.status)
            // }
            return new Promise(resolve => {
                resolve({
                    valid: !response.data.status,
                    data: !response.data.status ? undefined : { message: 'Not this value' }
                });
            });
        }).catch((err) => {
        });
    },
    params: ['api'],
   // message: 'This {_field_} is already exists!'
});

export default {
    data: () => ({
        name: 'ValidationObserver',
    }),
    components: {
        ValidationObserver,
    }}

