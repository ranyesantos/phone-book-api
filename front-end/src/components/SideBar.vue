<template>
    <aside class="sidebar">
        <ul class="sidebar-menu">
            <li>
                <router-link to="/home" class="sidebar-item" active-class="active"><i class="fa-solid fa-user"></i>Contatos</router-link>
            </li>
            <li>
                <router-link to="/trash-bin" class="sidebar-item" active-class="active"><i class="fa-solid fa-trash"></i>Lixeira</router-link>
            </li>
            <logoutButton class="logout-btn" />
        </ul>
    </aside>
</template>


<script>
    import logoutButton from './logoutButton.vue'
    export default {
        name: 'Sidebar',
        components: {
            logoutButton
        }
    }
</script>

<style scoped>

.sidebar-item.active {
    background-color: #dad8d8c0;
    color: rgb(0, 0, 0);
    border-radius: 7px;
}

.sidebar {
    position: fixed;
    top: 60px; 
    left: 0;
    background: rgb(195,188,191);
    background: radial-gradient(circle, rgba(195,188,191,1) 0%, rgba(107,154,237,1) 0%);
    color: white;
    padding: 15px;
    width: 190px;
    height: 100%;
}

.sidebar-menu {
    display: flex;
    justify-content: center;
    flex-direction: column;
    list-style: none;
    padding: 0;
    margin: 0;
}
.logout-btn {
    position: fixed;
    bottom: 60px;
    left: 40px;
    background-color: transparent;
    color: rgb(255, 255, 255);
    border: none;
    width: 60px;
    height: 60px;
    font-size: 20px;
}

.sidebar-item {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin-left: 12px;
    padding: 15px;
    font-size: 22px;
    margin-top: 20px;
    margin-bottom: 10px;
    color: white;
    text-decoration: none;
}

.sidebar-item i {
    font-size: 20px;
    margin-right: 20px;
}

.sidebar-item:hover {
    background-color: #ecdede21;
    border-radius: 7px;
}

@media screen and (max-width: 1040px) {
  .sidebar {
    display: none;
  }
}
</style>
