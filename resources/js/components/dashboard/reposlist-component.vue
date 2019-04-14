<template>
    <div class="wrapper">
        <!--<div>-->
            <!--<vSelect :options="options"></vSelect>-->
        <!--</div>-->
        <!--<img src="../../../../public/img/preloader/giphy.gif" alt="">-->
        <ul class="list-group"  >
            <li class="list-group-item" v-for="(item, index) in list" v-show="list"> <span class="mr-3">{{++index}}</span>{{item.full_name}}</li>
        </ul>
    </div>
</template>

<script>
    import lodash from 'lodash'
    import axios from 'axios';
    import vSelect from 'vue-select'
    Vue.component('v-select', vSelect);
    export default {
        data(){
            return {
                list:[],
            }
        },
        components: {
            'vSelect': vSelect
        },
        mounted(){
            axios.get('https://api.github.com/repositories', {
                headers: {
                    'Content-Type': 'application/json',
                }
            })
                .then((res) => {
                    this.list = _.chunk(res.data,50)[0]
                })
        }
    }
</script>

<style scoped>

</style>