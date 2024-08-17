<template>

    <button :type="type" class="base-button">
        <slot></slot>
    </button>

</template>

<script>

    export default {
        props: {
            type: {
                type: String,
                default: 'button',
            },
        },
    }

</script>

<style scoped>

.base-button {
    
    border-radius: 30px;
    background-color: rgb(5, 63, 170);
    color: rgb(255, 255, 255);
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.base-button:hover {
    background-color: rgb(4, 50, 135); 
}

</style>
  