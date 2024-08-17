<template>
    <div class="main">
        <div class="register-container">
            <h1>Crie a sua conta</h1>
            <form @submit.prevent="register">

                <input type="text" placeholder="Nome" v-model="name" class="base-input"/>
                <input type="text" placeholder="E-mail" v-model="email" class="base-input"/>
                <input type="password" placeholder="Senha" v-model="password" name="password" class="base-input"/>

                <BaseButton class="base-button" type="submit">Cadastrar</BaseButton>

            </form>
            <p>Já possui uma conta? <a @click="loginRedirect">Entrar</a></p>
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
        password: '',
        };
    },
    setup() {
        const router = useRouter(); 

        const loginRedirect = () => {
            router.push('/'); 
        };
        
        return {
            loginRedirect
        };
    },
    methods: {
        async register() {
            try {

                const response = await api.post('/register', {
                    name: this.name,    
                    email: this.email,
                    password: this.password
                });

                this.token = response.data.token;
                localStorage.setItem('authToken', this.token);
                this.$router.push('/');

            } catch (error) {
                console.error('Erro ao registrar:', error.response.data.message);
            }
        }
    }
}
</script>


<style>
   .main {
    font-family: 'Roboto', 'sans-serif';
    display: flex;
    justify-content: center;
    height: 100vh;
    align-items: center;
    background-color: #333;
    
}

.register-container {
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    background-color: rgb(216, 31, 31);
    width: 580px;
    height: 590px;
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

.base-input {
    width: 480px;
    height: 65px;
    margin-bottom: 45px; 
    border-radius: 4px;
    border: 0.9px solid rgba(61, 61, 61, 0.384);
    border-color: none;
    text-indent: 20px;
    font-size: 22px ;
}

input::placeholder {
    color: rgba(56, 55, 55, 0.788);
    font-size: 18px;
    left: 3px;
    opacity: 0.9;
   height: 65px;
}

.base-button {
    width: 490px;
    height: 62px;
    font-size: 24px;
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