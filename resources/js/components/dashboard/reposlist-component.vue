<template>
    <div class="wrapper">
        <!--<div>-->
        <!--<vSelect :options="options"></vSelect>-->
        <!--</div>-->
        <!--<img src="../../../../public/img/preloader/giphy.gif" alt="">-->
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between" v-for="(item, index) in list" v-show="list">
                <span><span class="mr-3">{{++index}}</span>{{item.full_name}}</span>
                <template v-if="item.stared === true">
                    <span> <i class="far fa-thumbs-down" @click.prevent="likeRepo(item.name)"></i></span>

                </template>
                <template v-else>
                    <span> <i class="far fa-thumbs-up" @click.prevent="diseLikeRepo(item.name)"></i></span>
                </template>
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
            //get random repos
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

            //Get stared Users repos
            let usersStaredRepos = await axios.get('https://api.github.com/users/lion1121/starred').then((res) => {
                return res.data;
            });

            //If repos has been stared add property stared = true, else = false
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
        },
        actions: {

        }
    }
</script>

<style scoped>
    .far {
        cursor: pointer;
    }
</style>