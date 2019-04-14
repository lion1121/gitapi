<template>
    <div class="wrapper">
        <!--<div>-->
        <!--<vSelect :options="options"></vSelect>-->
        <!--</div>-->
        <!--<img src="../../../../public/img/preloader/giphy.gif" alt="">-->
        <ul class="list-group">
            <li class="list-group-item" v-for="(item, index) in list" v-show="list">
                <span class="mr-3">{{++index}}</span>{{item.full_name}}
                <span>{{item.stared}}</span>
            </li>
        </ul>
    </div>
</template>

<script>
    import lodash from 'lodash'
    import axios from 'axios';
    import vSelect from 'vue-select'

    Vue.component('v-select', vSelect);
    export default {
        data() {
            return {
                list: [],
            }
        },
        components: {
            'vSelect': vSelect
        },
        async created() {

            let repos = await  axios(
                {
                    method: 'get',
                    url: 'https://api.github.com/repositories',
                    auth: {
                        username: 'bayduzh89@gmail.com',
                        password: '0985594949lion'
                    }
                }).then((res) => {
                return _.chunk(res.data, 50)[0];
            });

            let usersStaredRepos = await axios.get('https://api.github.com/users/lion1121/starred').then((res) => {
                return res.data;
            });

            repos.map(function (item) {
                for (let i = 0; i < usersStaredRepos.length; i++) {
                    if (item.full_name === usersStaredRepos[i].full_name) {
                        item.stared = true;
                    } else {
                        item.stared = false;
                    }
                }
            });
            this.list = repos;
        }
    }
</script>

<style scoped>

</style>