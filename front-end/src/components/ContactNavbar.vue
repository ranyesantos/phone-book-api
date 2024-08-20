<template>
    <div class="navbar">
        <div class="navbar-content">
            
            <a @click="goBack"><i class="fa-solid fa-arrow-left"></i></a>
            <span>{{ title }}</span>
            
        </div>
    </div>
</template>

<script>
export default {
    name: 'NavBar',
    props: {
        title: {
            type: String,
            default: ''
        }
    },
    methods: {
        goBack() {
        this.$router.go(-1); 
    }
  }
};
</script>

<style scoped>
.navbar {
    display: flex;
    width: 100%;
    justify-content: flex-start;
    position: sticky;
    top: 0;
    color: #000000; 
    padding: 10px;
    margin-left: 2px;
    z-index: 20;
}

.navbar-content {
    margin-top: 30px;
    color: #000000; 
    font-size: 27px;
    display: flex;
    align-items: center;
    width: 100%; 
}

.navbar-content i {
    margin-right: 20px;
}

.navbar-content button {
    margin-left: 20px; 
    padding: 5px 10px;
    font-size: 16px;
}
a:hover {
    background-color: transparent;
    cursor: pointer;
    text-decoration: none;
    color: rgb(87, 85, 85);
}
</style>