<template>
    <Navbar />
    <Sidebar />
    <RouterView />

</template>

<script >
import  Navbar  from '../components/NavBar.vue'
import  Sidebar  from '../components/SideBar.vue'
export default {
  components: {
        Navbar,
        Sidebar,
  }
}

</script>

<style>
</style>
