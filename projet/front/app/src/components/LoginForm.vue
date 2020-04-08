<template>
    <div id="login-form">
        <b-form @submit="onSubmit">

            <b-form-group id="input-group-1" label="Email" label-for="input-1">
                <b-form-input id="input-1" type="email" v-model="form.email" required placeholder="Enter email"></b-form-input>
            </b-form-group>

            <b-form-group id="input-group-2" label="Mot de passe" label-for="input-2">
                <b-form-input id="input-2" type="password" v-model="form.password" required placeholder="Enter password"></b-form-input>
            </b-form-group>

            <b-button type="submit" variant="primary">Se connecter</b-button>
        </b-form>
    </div>
</template>

<script>
    import { mapActions } from 'vuex'

    export default {
        data() {
            return {
                form: {
                    email: "",
                    password: ""
                }
            };
        },
        methods: {
            ...mapActions('auth', ['login']),
            onSubmit(evt) {
                evt.preventDefault();
                this.login({"username": this.form.email, "password": this.form.password})
            }
        }
    };
</script>

<style scoped>
    #login-form {
        width: 50%;
        margin: 10% auto 0;
    }
</style>