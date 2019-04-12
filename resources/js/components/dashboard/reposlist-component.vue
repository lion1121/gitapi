<template>
</template>

<script>
    import axios from 'axios';
    export default {
        data(){
            return {
                list:[]
            }
        },
        mounted(){
            axios.get('https://api.github.com/repositories', {
                headers: {
                    'Content-Type': 'application/json',
                    // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
                .then((res) => {
                    console.log(res)
                })
        }
    }
</script>

<style scoped>

</style>