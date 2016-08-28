import Vue from 'vue';
import Todos from '../components/Todos.vue';


Vue.use(require('vue-resource'));

Vue.http.headers.common['X-CSRF-TOKEN'] = $("input[name=_token]").attr("value");

new Vue({
    el : '#app',
    data : {
        hello : 'Hello'
    },
    components : { Todos }
});


