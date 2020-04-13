<template>
    <div>
        <NavBar/>
        <template>
            <b-button v-on:click="aled()">P'tit bouton des familles</b-button>
        </template>
    </div>
</template>

<script>
    import NavBar from '@/components/Navbar.vue'
    import {mapActions} from "vuex";

    export default {
        name: 'Test',
        components: {
            NavBar
        },
        methods: {
            ...mapActions('auth', ['getAllUsers']),
            aled() {
                this.getAllUsers();
            }
        }
    }
</script>
