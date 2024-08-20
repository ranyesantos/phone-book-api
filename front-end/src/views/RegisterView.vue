<template>
    <div class="main">
        <div class="register-container">
            <h1>Crie a sua conta</h1>
            <form @submit.prevent="register">

                <div class="input-box">
                    <input type="text" placeholder="Nome" required v-model="name" class="base-input"/>
                    <div class="error">
                        <p v-if="errors.name" class="error-message">{{ errors.name }}</p>
                    </div>
                </div>
                <div class="input-box">
                    
                    <input type="text" placeholder="E-mail" required v-model="email" class="base-input"/>
                    <div class="error">
                        <p v-if="errors.email" class="error-message">{{ errors.email }}</p>
                    </div>
                </div>

                <div class="input-box">
                    <input type="password" placeholder="Senha" required v-model="password" name="password" class="base-input"/>
                    <div class="error">
                        <p v-if="errors.password" class="error-message">{{ errors.password }}</p>
                    </div>
                </div>
                <BaseButton class="base-button" type="submit">Cadastrar</BaseButton>

            </form>
            <p>Já possui uma conta? <a @click="loginRedirect">Entrar</a></p>
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
            name:'',
            email:'',
            password: '',
            errors: {
                "name": '',
                "email": '',
                "password": '',
            },
        };
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
        loginRedirect() {
            this.$router.push({ name: 'login' });
        },
        
        async register() {
            try {
                
                await api.post('/register', {
                    name: this.name,    
                    email: this.email,
                    password: this.password
                    
                });

                this.$router.push('/');

            } catch (error) {
                if (error.response && error.response.data && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                } else {
                    console.error('erro desconhecido:', error);
                }
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
        font-size: 13px;
        color: red;
    }
}
.input-box {
    display: flex;
    flex-direction: column;
    margin-bottom: 3px;

}

.base-input {
    width: 480px;
    height: 65px;
    margin-bottom: 7px; 
    border-radius: 4px;
    border: 0.9px solid rgba(61, 61, 61, 0.384);
    border-color: none;
    text-indent: 20px;
    font-size: 22px ;
}

.register-container {
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    background-color: rgb(255, 255, 255);
    width: 580px;
    height: 700px;
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
    .register-container {
        
        height: 88%;
        width: 90%;
        max-width: 100%;
        margin-top: 0;
        padding: 10px;
        overflow-y: auto;
    }
    .input-box {
        width: 100%;
    }
    .base-input {
        width: 100%;
        height: 50px;
        margin-bottom: 15px;
        font-size: 14px;
    }
    .base-button {
        max-width: 100%;
    }
    .form-container {
        width: 100%;
    }

    

    p {
        font-size: 16px;
        margin-top: 10px;
    }
}
</style>