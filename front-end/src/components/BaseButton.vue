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
    width: 490px;
    height: 62px;
    border-radius: 30px;
    background-color: rgb(5, 63, 170);
    color: rgb(255, 255, 255);
    font-size: 24px;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
    }

    .base-button:hover {
    background-color: rgb(4, 50, 135); 
    }

</style>
  