<template>
    <aside class="sidebar">
        <ul class="sidebar-menu">
            <li><router-link to="/dashboard" class="sidebar-item"><i class="fa-solid fa-user"></i>Contatos</router-link></li>
        </ul>
    </aside>
</template>

<script>
    export default {
        name: 'Sidebar',
    }
</script>

<style scoped>
.sidebar {
    position: fixed; /* Fixa a sidebar na tela */
    top: 60px; /* Define a posição da sidebar abaixo da navbar (ajuste conforme necessário) */
    left: 0;
    width: 250px;
    height: calc(100vh - 60px); /* Altura total da tela menos a altura da navbar */
    background-color: #333;
    color: white;
    padding: 15px;
}




.sidebar-menu {
    display: flex;
    justify-content: center;
    flex-direction: column;
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-item {
    display: flex;
    align-items: center;
    justify-content: start;
    padding: 20px;
    font-size: 17px;
    margin-bottom: 10px;
    color: white;
    text-decoration: none;
    i {
        font-size: 20px;
        margin-right: 20px;
    }
}


.sidebar-item:hover {
    background-color: #575757;
    border-radius: 4px;
}
</style>
