<template>
    <div class="main">
        <div class="login-container">
            <h1>Crie a sua conta</h1>
            <form>

                <BaseInput
                    type="text"
                    placeholder="Nome"
                    v-model="Nome"
                    class="baseinput"
                />
                <BaseInput
                    type="email"
                    placeholder="E-mail"
                    v-model="email"
                    class="baseinput"
                />
                <BaseInput
                    type="password"
                    placeholder="Senha"
                    v-model="password"
                    class="baseinput"
                />

                <BaseButton type="submit">Cadastrar</BaseButton>

            </form>
            <p>Já possui uma conta? <a @click="loginRedirect">Entrar</a></p>
        </div>
    </div>
</template>


<script>
    import BaseInput from '../components/BaseInput.vue';
    import BaseButton from '../components/BaseButton.vue';
    import { useRouter } from 'vue-router';

    export default {
        components: {
            BaseInput,
            BaseButton,
        },
        setup() {
            const router = useRouter(); // Obtém o roteador

            const loginRedirect = () => {
                router.push('/'); // Navega para a rota /register
            };

            return {
                loginRedirect
            };
        },
    }
</script>


<style>
   .main {
    font-family: 'Roboto', 'sans-serif';
    display: flex;
    justify-content: center;
    height: 100vh;
    align-items: center;
    background-color: rgb(5, 63, 170);
    
}

.login-container {
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    background-color: rgb(255, 255, 255);
    width: 580px;
    height: 65vh;
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