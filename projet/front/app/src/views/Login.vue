<template>
    <div>
        <NavBar/>
        <LoginForm/>
    </div>
</template>

<script>
import NavBar from '@/components/Navbar.vue'
import LoginForm from '@/components/LoginForm.vue'

export default {
  name: 'Home',
  components: {
    NavBar,
    LoginForm
  }
}
</script>
