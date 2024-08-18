<template>
<Navbar />
<div class="master">
    <SideBar />
    <section class="content">
        <div class="form-container">

            <ContactNavbar title="Adicionar Contato" />

            <form @submit.prevent="add">

                <div class="profile-picture">
                    <div class="image-container">
                        <img :src="imageUrl || defaultImage" alt="Profile Picture" class="profile-img" />

                        <input type="file" @change="handleImageUpload" accept="image/*" class="file-input" />
                    </div>
                    <p v-if="!imageUrl">Escolha uma imagem</p>

                </div>

                <div>
                    
                    <div class="input-box">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" placeholder="Nome" v-model="name" class="base-input"/>
                    </div>

                    <div class="input-box">
                        <i class="fa-solid fa-phone"></i>
                        <input type="number" placeholder="Telefone" v-model="phone" class="base-input"/>
                    </div>

                    <div class="input-box">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" placeholder="E-mail" v-model="email" class="base-input"/>
                    </div>

                </div>

                <BaseButton class="base-button" type="submit">Salvar</BaseButton>
            </form>
        </div>
    </section>
</div>
</template>

<script>
const token = localStorage.getItem('authToken')
console.log(token)

import Navbar from '../../components/NavBar.vue';
import SideBar from '../../components/SideBar.vue';
import BaseButton from '../../components/BaseButton.vue';
import ContactNavbar from '../../components/ContactNavbar.vue';
import api from '../../services/apiService';
import defaultImage from '../../assets/img/user.png';


export default {
    components: {
        Navbar,
        SideBar,
        BaseButton,
        ContactNavbar,
    },
    data() {
        return {
            name: '',
            phone: '',
            email: '',
            imageUrl: null,
            file: null,
            defaultImage  // Define a imagem padrão
        };
    },
    methods: {
        handleImageUpload(event) {
        const file = event.target.files[0];
        if (file) {
            this.file = file;
            const reader = new FileReader();
            reader.onload = (e) => {
                this.imageUrl = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            this.imageUrl = ''; 
        }
    },
    async add() {
        const formData = new FormData();
        formData.append('name', this.name);
        formData.append('phone', this.phone);
        formData.append('email', this.email);
        
        if (this.file) {
            formData.append('profile_picture', this.file);
        }
        
        try {
            const token = localStorage.getItem('authToken');
            await api.post('/contacts', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    Authorization: `Bearer ${token}`
                }
            });
            
            this.$router.push('/home');
        } catch (error) {
            console.error('Erro ao registrar:', error.response?.data?.message || error.message);
            this.$router.push('/home');
        }
    }
}
}
</script>

<style>


.master {
    display: flex;
    flex: 1;
    margin-top: 60px; /* Espaço para a altura da navbar */
    justify-content: flex-start;
    height: 100vh;
    overflow: hidden;
}

.content {
    height: 100%;
    display: flex;
    flex-direction: column;
    margin-left: 280px; /* Largura da sidebar */
    margin-right: 10px;
    flex: 1;
    padding: 0; /* Espaçamento interno */
    background-color: #f8f9fa; /* Cor de fundo para a área de conteúdo */
    border-radius: 12px;
    margin-bottom: 8px;
}


.form-container {
    display: flex;
    justify-content: flex-start;
    flex-direction: column;
    align-items: center;
    height: 100%;
    padding-left: 80px;
}


.profile-picture {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.image-container {
    position: relative;
    margin-bottom: 0px;
}

.profile-img {
    width: 150px; 
    height: 150px;
    border-radius: 50%; 
    object-fit: cover;
    border: 2px solid #ddd;
}

.file-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0; 
    cursor: pointer; 
}

p {
    margin-top: 0px;
    color: #888; 
}

.navbar {
    display: flex;
    width: 100%;
    justify-content: flex-start;
    position: sticky; /* Fixa a navbar dentro do componente */
    top: 0;
    color: #000000; /* Cor do texto na navbar */
    padding: 0px;
    padding-left: 0px;
    z-index: 20; /* Garante que a navbar fique acima da tabela */
}

.navbar-content {
    margin-top: 50px;
    color: #000000; /* Cor do texto da navbar */
    font-size: 27px;
    i {
        margin-right: 20px;
    }
}


.input-box {
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 30px;
}

.input-box i {
    margin-right: 30px;
    margin-bottom: 40px;
}


.base-input {
    width: 70vh;
    height: 45px;
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
}

.base-button {
    width: 100px;
    height: 62px;
    font-size: 24px;
}

form {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    width: 100%;
    margin-top: 40px;
}
</style>