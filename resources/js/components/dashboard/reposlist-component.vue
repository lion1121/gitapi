<template>
    <div class="wrapper">
        <div class="row">
            <div class="col-12">
                <h2 class="repos_title">Search git repo</h2>

                <form @submit.prevent="searchRepos(q)" class="form-inline">
                    <input class="form-control col-10" v-model="q" type="search"
                           placeholder="Введите название репозитория" aria-label="Search">
                    <button class="btn btn-outline-success col-2" type="submit">Search</button>
                </form>
            </div>
            <div class="col-12 mt-2">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between" v-for="(item, index) in foundRepos">
                        <span><span class="mr-3">{{++index}}</span><a :href="'/user/dashboard/repo/'+ item.id" style="cursor: pointer">{{item.full_name}}</a></span>

                        <template v-if="item.is_liked === 0">
                            <span> <i class="far fa-thumbs-up" @click.prevent="likeRepos(item)"></i></span>
                        </template>

                        <template v-if="item.is_liked === 1">
                            <span> <i class="far fa-thumbs-down" @click.prevent="diselikeRepos(item)"></i></span>
                        </template>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <h2 class="repos_title">Git repos list</h2>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between" v-for="(item, index) in list"
                        v-show="list">
                        <span><span class="mr-3">{{++index}}</span><a :href="'/user/dashboard/repo/'+ item.id" style="cursor: pointer">{{item.full_name}}</a></span>

                        <template v-if="item.is_liked === 0">
                            <span> <i class="far fa-thumbs-up" @click.prevent="likeRepos(item)"></i></span>
                        </template>

                        <template v-if="item.is_liked === 1">
                            <span> <i class="far fa-thumbs-down" @click.prevent="diselikeRepos(item)"></i></span>
                        </template>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import lodash from 'lodash'
    import axios from 'axios';

    export default {
        data() {
            return {
                list: [],
                q: '',
                foundRepos: []
            }
        },
        props:['url'],
        async created() {
            //get random repos
            let repos = await  axios(
                {
                    method: 'get',
                    url: 'https://api.github.com/repositories',
                }).then((res) => {
                return _.chunk(res.data, 50)[0];
            });

            //Get stared Users repos
            let usersStaredRepos = await axios.get('/ajax/getUserRepos').then((res) => {
                console.log(res.data);
                return res.data;
            });

            //If repos has been liked add property 1, else = 0
            repos.map(function (item) {
                if (usersStaredRepos.length === 0) {
                    item.is_liked = 0;
                } else {
                    for (let i = 0; i < usersStaredRepos.length; i++) {
                        if (item.full_name === usersStaredRepos[i].full_name) {
                            item.is_liked = usersStaredRepos[i].is_liked;
                        } else if (!item.hasOwnProperty('is_liked')) {
                            item.is_liked = 0;
                        }
                    }
                }
            });

            this.list = repos;
        },
        methods: {
            async likeRepos(repo) {
                await  axios.post('/ajax/likeRepo', {
                    repoName: repo.full_name
                }).then((res) => {
                    this.list.map(function (item) {
                        if (item.full_name === res.data) {
                            item.is_liked = 1;
                        }
                    });
                    if (this.foundRepos.length > 0) {
                        this.foundRepos.map(function (item) {
                            if (item.full_name === res.data) {
                                item.is_liked = 1;
                            }
                        });
                    }
                })
            },
            //
            diselikeRepos(repo) {
                axios.post('/ajax/diselikeRepo', {
                    repoName: repo.full_name
                }).then((res) => {
                    this.list.map(function (item) {
                        if (item.full_name === res.data) {
                            item.is_liked = 0;
                        }
                    });
                    if (this.foundRepos.length > 0) {
                        this.foundRepos.map(function (item) {
                            if (item.full_name === res.data) {
                                item.is_liked = 0;
                            }
                        });
                    }
                })
            },
            //Fetch repos
            async searchRepos(q) {
                if (q !== '') {
                    let fRepos = await axios.get(`https://api.github.com/search/repositories?q=${q}`).then((res) => {
                        return _.chunk(res.data.items, 50)[0];
                    });
                    let userRepos = await axios.get('/ajax/getUserRepos').then((res) => {
                        return res.data;
                    });
                    fRepos.map(function (item) {
                        if(userRepos.length === 0){
                            item.is_liked = 0;
                        } else {
                            for (let i = 0; i < userRepos.length; i++) {
                                if (item.full_name === userRepos[i].full_name && item.hasOwnProperty('is_liked')) {
                                    item.is_liked = userRepos[i].is_liked;
                                } else if (!item.hasOwnProperty('is_liked')) {
                                    item.is_liked = 0;
                                }
                            }
                        }

                    });
                    this.foundRepos = fRepos;
                }
            },
        }
    }
</script>

<style scoped>
    .far {
        cursor: pointer;
    }
</style>