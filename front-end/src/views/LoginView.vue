<template>
    <div class="master">
        <div class="login-container">
            <h1>Acesse a sua conta</h1>
            <form @submit.prevent="login">

                <input type="text" placeholder="E-mail" v-model="email" class="base-input"/>
                <input type="password" placeholder="Senha" v-model="password" class="base-input"/>

                <BaseButton class="base-button" type="submit">Entrar</BaseButton>
            </form>

            <p>Não tem uma conta? <a @click="registerRedirect">Registre-se</a></p>

        </div>
    </div>
</template>

<script>

import BaseButton from '../components/BaseButton.vue';
import { useRouter } from 'vue-router';
import api from '../services/apiService';

export default {

    

    components: {
        BaseButton,
    },

    data() {
        return {
            email: '',
            password: ''
        }
    },

    setup() {
        const router = useRouter();

        const registerRedirect = () => {
            router.push('/register'); 
        };

        return {
            registerRedirect
        };
    },
    methods: {
        async login() {
    try {
        const response = await api.post('/login', {
            email: this.email,
            password: this.password,
        });
        this.token = response.data.token;
        localStorage.setItem('authToken', this.token);
        this.$router.push('/home')
    } catch (error) {
        console.error('Erro ao registrar:', error.response.data.message);
    }
}
    }
}
</script>

<style>
.master {
    font-family: 'Roboto', 'sans-serif';
    display: flex;
    justify-content: center;
    height: 100vh;
    margin: 0;
    align-items: center;
    background-color: #5743c9;
    
}

.base-input {
    width: 480px;
    height: 65px;
    margin-bottom: 45px; 
    border-radius: 4px;
    border: 0.9px solid rgba(61, 61, 61, 0.384);
    border-color: none;
    text-indent: 20px;
    font-size: 22px;
    max-width: 480px;
}

input::placeholder {
    color: rgba(56, 55, 55, 0.788);
    font-size: 18px;
    left: 3px;
    opacity: 0.9;
}

.base-button {
    width: 490px;
    height: 62px;
    font-size: 24px;
}

.login-container {
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    background-color: rgb(255, 255, 255);
    width: 580px;
    height: 550px;
    box-shadow: 0 4px 8px 2px rgba(26, 25, 25, 0.274);
    border-radius: 2.5px;
}


form {
    display: flex;
    flex-direction: column; 
    justify-content: center;
    align-items: center; 
    width: 100%;
    margin-top: 40px;
}


p {
    font-size: 16px;
    color: rgb(56, 56, 56);
    margin-top: 20px;
    text-align: center;
}

a {
    color: rgb(45, 117, 252);
    text-decoration: none;
    font-weight: bold;
    background-color: transparent;
    transition: color 0.3s ease, text-decoration 0.3s ease;
}

a:hover {
    text-decoration: underline;
    color: rgb(9, 87, 231);
    background-color: transparent;
}

@media (max-width: 650px) {
    .login-container {
        width: 60%;
        max-width: 100%;
        margin-top: 0;
        padding: 10px;
    }

    input {
        width: 100%;
        height: 50px;
        margin-bottom: 15px;
        font-size: 14px;
    }

    button {
        width: 100%;
        height: 50px;
        font-size: 16px;
    }

    p {
        font-size: 14px;
        margin-top: 10px;
    }
}
</style>