<template>
    <form @submit="" class="form-inline">
        <input class="form-control col-10" type="search" placeholder="Введите название репозитория" aria-label="Search">
        <button class="btn btn-outline-success col-2" type="submit">Search</button>
    </form>
</template>

<script>
    export default {
        data(){
            return {
                a:1
            }
        }
    }
</script>

<style scoped>

</style>