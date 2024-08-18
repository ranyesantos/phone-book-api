<template>
    <div class="navbar">
        <div class="navbar-content">
            <i class="fa-solid fa-arrow-left"></i>
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
    padding-left: 0px;
    z-index: 20;
}

.navbar-content {
    margin-top: 50px;
    color: #000000; 
    font-size: 27px;
}

.navbar-content i {
    margin-right: 20px;
}
</style>
