<template>
<div v-if="show" class="modal-overlay">
    <div class="modal-content">
        <h3>Confirmar Exclusão</h3>
        <p>Você tem certeza de que deseja excluir este contato?</p>
        <div class="modal-actions">
            <button class="yesBtn" @click="confirmDelete">Sim</button>
            <button class="noBtn" @click="cancelDelete">Não</button>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: {
        show: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        confirmDelete() {
            this.$emit('confirm');
        },
        cancelDelete() {
            this.$emit('cancel');
        }
    }
}
</script>

<style scoped>
    .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

button:hover {
    cursor: pointer;
}

.yesBtn {
    background-color: rgb(248, 40, 40);
    
}

.noBtn {
    background-color: rgba(78, 245, 78, 0.651);
}

.modal-content {
    display: flex;
    justify-content: space-between;
    flex-direction: column;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    height: 200px;
    width: 500px;

    h3 {
        font-size: 25px;
    }

    p {
        font-size: 20px;
    }
}

.modal-actions{
    padding-bottom: 10px;

    button {
        height: 50px;
        width: 90px;
        font-size: 20px;
        border: none;
        border-radius: 10px;
        color: rgb(0, 0, 0);
        margin: 5px;
    }
}
</style>