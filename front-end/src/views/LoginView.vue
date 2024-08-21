<template>
    <div class="master">
        <div class="login-container">
            <h1>Acesse a sua conta</h1>
            <form @submit.prevent="login" class="form-container">
                <div class="login-box">
    
                    <input type="text" required placeholder="E-mail" v-model="email" class="base-input"/>
    
                    <input type="password" required placeholder="Senha" v-model="password" class="base-input"/>
                    <div class="error">
                        <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
                    </div>
                </div>
                <BaseButton class="base-button" type="submit">Entrar</BaseButton>
            </form>
            

            <p>Não tem uma conta? <a @click="registerRedirect">Registre-se</a></p>

        </div>
    </div>
</template>

<script>

import BaseButton from '../components/BaseButton.vue';
import api from '../services/apiService';

export default {

    components: {
        BaseButton,
    },

    data() {
        return {
            email: '',
            password: '',
            errorMessage: '' 
        }
    },
    mounted() {
        if (!sessionStorage.getItem('pageReloaded')) {
            sessionStorage.setItem('pageReloaded', 'true');
            
            window.location.reload();
        } else {
            sessionStorage.removeItem('pageReloaded');
        }
    },
    
    methods: {
        

        registerRedirect() {
            this.$router.push({ name: 'register' });
        },

        async login() {
            try {
                
                const response = await api.post('/login', {
                    email: this.email,
                    password: this.password,
                });
                if (response.status === 201) {
                    const token = response.data.token;

                    localStorage.setItem('user', JSON.stringify(response.data.user));
                    localStorage.setItem('authToken', token);
                    this.$router.push({ name: 'home' });

                } 

            } catch (error) {
                if (error.response && error.response.data && error.response.data.message) {
                    this.errorMessage = error.response.data.message;
                } else {
                    this.errorMessage = 'Erro desconhecido';
                }
                console.error('Erro ao registrar:', this.errorMessage);
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
    background: rgb(195,188,191);
    background: radial-gradient(circle, rgba(195,188,191,1) 0%, rgba(107,154,237,1) 100%);
}
.error {
    min-height: 30px;
    display: block;
    justify-content: flex-start;
    align-items: center;
    position: relative;
    margin-left: 10px;
    color: transparent;
    p {
        margin-top: 0px;
        font-size: 15px;
        color: red;
    }
}

.login-box {
    display: flex;
    justify-content: center;
    flex-direction: column;
}

.input-box {
    display: flex;
    flex-direction: column;
    margin-bottom: 3px;
    
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
    
}
/* .error {
    color: red;
    padding: 2px;
    padding-bottom: 40px;
    margin: 0;
    background-color: transparent;
    p {
        font-size: 21px;
    }
} */
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
    border-radius: 29px;
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
    font-size: 20px;
    color: rgb(0, 0, 0);
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

@media (max-width: 1040px) {
    .login-container {
        height: 70%;
        width: 90%;
        max-width: 100%;
        margin-top: 0;
        padding: 10px;
    }

    .login-box {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .base-input {
        width: 100%;
        height: 50px;
        margin-bottom: 18px;
        font-size: 14px;
    }
    .base-button {
        margin-top: 10px;
        max-width: 100%;
    }
    .form-container {
        width: 100%;
    }

    .error {
        padding-bottom: 0;
    }

    p {
        font-size: 16px;
        margin-top: 10px;
    }
}
</style>