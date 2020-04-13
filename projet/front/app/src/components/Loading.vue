<template>
    <div class="loading-overlay" v-show="isLoading">
        <div class="content">
            <i :class="loader" aria-hidden="true"></i><br>
            <p>{{text}}</p>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default{
        name: 'loading',
        props: {
            loader: {
                type: String,
                default: 'fa fa-spinner fa-spin'
            },
            text: {
                type: String,
                default: 'Chargement ...'
            }
        },
        computed: {
            ...mapGetters('loading', ['isLoading'])
        },
    }
</script>

<style scoped>
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        text-align: center;
        padding: 20%;
        color: white;
        z-index: 9999999;
        background: rgba(0,0,0,0.6);
    }
</style>