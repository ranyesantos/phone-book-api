<template>
    <button class="add-button" @click="handleClick">
        <i class="fa-solid fa-plus"></i>
        <slot></slot>
    </button>
</template>

<script>

export default {
    name: 'AddButton',
    props: {
        redirectUrl: {
        type: String,
        default: '' 
        }
    },
    methods: {
        handleClick() {
            if (this.redirectUrl) {
                this.$router.push(this.redirectUrl).then(() => {
                    window.location.reload(); 
                });
            }
        }
    }
}

</script>

<style scoped>
.add-button {
    position: fixed;
    bottom: 60px; 
    right: 60px;
    width: 90px;
    height: 90px;
    padding: 0; 
    font-size: 47px; 
    background-color: #393a3a; 
    color: #ffffff; 
    border: none; 
    border-radius: 50%; 
    display: flex; 
    justify-content: center; 
    align-items: center; 
    cursor: pointer;
}

.add-button:hover {
    background-color: #636464;
}
@media screen and (max-width: 1040px) {
  .add-button{
    bottom: 50px; 
    right: 30px;
    width: 70px;
    height: 70px;
    padding: 0; 
    font-size: 47px; 
  }
}
</style>
