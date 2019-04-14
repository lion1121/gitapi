<template>
    <div class="row" v-if="repo !== null">
       <div class="col-4">Id</div> <div class="col-8">{{repo.id}}</div>
       <div class="col-4">Name</div> <div class="col-8">{{repo.name}}</div>
       <div class="col-4">Owner</div> <div class="col-8">{{repo.owner.login}}</div>
       <div class="col-4">Stars</div> <div class="col-8">{{repo.stargazers_count}}</div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "reposinfo-component",
        data() {
            return {
                nameOwner: null,
                repo: null
            }
        },
        async created() {
            let url = window.location.href;
            let urlArray = url.split('/');
            let nameOwner = urlArray.slice(Math.max(urlArray.length - 2, 1)).join('/');
            this.repo = await axios.get('https://api.github.com/repos/' + nameOwner).then((res) => {
                return res.data
            });

        }
    }
</script>

<style scoped>

</style>