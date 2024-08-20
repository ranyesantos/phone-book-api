<template>
    <header>
        <nav class="navbar">
            <div class="navbar-container">
                <router-link to="/home" class="navbar-logo"><i class="fa-solid fa-book">                   
                </i></router-link>
            </div>
        </nav>
    </header>
</template>

<script>
    export default {
        name: 'Navbar',
        methods: {
          toggleMenu() {
            this.isMenuActive = !this.isMenuActive;
          }
        }
    }
</script>

<style scoped>

header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000; 
}

.navbar {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 60px;
    z-index: 1000;
    background: radial-gradient(circle, rgba(195,188,191,1) 0%, rgba(107,154,237,1) 0%);
}

.navbar-container {
    display: flex;
    position: fixed;
    align-items: center;
    width: 100%;
    max-width: 1200px;
}

.navbar-logo {
    color: white;
    font-size: 32px;
    text-decoration: none;
    font-weight: bold;
    padding-top: 20px;
    padding-left: 40px;
}
.navbar-logo:hover {
    background-color: transparent
}

.navbar-menu {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
}

.navbar-item {
    color: white;
    text-decoration: none;
    padding: 10px 15px;
    font-size: 18px;
}

.navbar-item:hover {
    background-color: #575757;
    border-radius: 4px;
}




@media (max-width: 1040px) {
    .navbar{
        display: none;
    }
}
</style>
