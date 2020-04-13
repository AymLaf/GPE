<template>
    <div>
    <b-navbar toggleable="lg" type="dark" variant="info">
        <b-navbar-brand href="#"><img src="media/logo_fond-blanc.png" alt="Kitten" width="30px" height="30px">&nbsp;Réucopro</b-navbar-brand>
        <b-navbar-toggle v-if="getUser.uuid" target="nav-collapse"></b-navbar-toggle>
        <b-collapse v-if="getUser.uuid" id="nav-collapse" is-nav>
            <!-- Right aligned nav items -->
            <b-navbar-nav class="ml-auto">
                <b-nav-item :to="{name: 'Test'}" right>Test</b-nav-item>
                <b-nav-item-dropdown right>
                <!-- Using 'button-content' slot -->
                <template v-slot:button-content>
                    Menu
                </template>
                <b-dropdown-item href="/profile">Profile</b-dropdown-item>
                <b-dropdown-item @click.prevent="logout">Sign Out</b-dropdown-item>
                </b-nav-item-dropdown>
            </b-navbar-nav>
        </b-collapse>
    </b-navbar>
    </div>
</template>

<script>
    import { mapActions } from 'vuex'
    import { mapGetters } from 'vuex'

    export default {
        methods: {
            ...mapActions('auth', ['logout'])
        },
        computed: {
            ...mapGetters('auth', ['getUser']),
        }
    }
</script>