<template>
    <header>
        <nav class="navbar">
            <div class="navbar-container">
                <router-link to="/home" class="navbar-logo">Logo</router-link>
                
                <!-- <button class="navbar-toggle" @click="toggleMenu">
                    ☰
                </button> -->
            </div>
        </nav>
    </header>
</template>

<script>
    export default {
        name: 'Navbar',
        data() {
            return {
                isMenuActive: false
            };
        },
        // methods: {
        //   toggleMenu() {
        //     this.isMenuActive = !this.isMenuActive;
        //   }
        // }
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
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 60px; /* Defina uma altura fixa */
    z-index: 1000; /* Garante que a navbar fique acima dos outros elementos */
    background-color: #333;
}

.navbar-container {
    display: flex;
    align-items: center;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
}

.navbar-logo {
    color: white;
    font-size: 24px;
    text-decoration: none;
    font-weight: bold;
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

.navbar-toggle {
    display: none;
    background: none;
    border: none;
    color: white;
    font-size: 24px;
}


@media (max-width: 768px) {
    .navbar-menu {
        display: none;
        flex-direction: column;
        width: 100%;
    }

    .navbar-menu.active {
        display: flex;
    }

    .navbar-item {
        padding: 10px;
        text-align: center;
        border-top: 1px solid #444;
    }

    .navbar-toggle {
        display: block;
    }
}
</style>
