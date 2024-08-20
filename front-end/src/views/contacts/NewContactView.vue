<template>
<Navbar />
<div class="master">
    <SideBar />
    <section class="content">
        <div class="form-container">

            <ContactNavbar title="Adicionar Contato" />

            <form @submit.prevent="add" class="form-box">

                <div class="profile-picture">
                    <div class="image-container">
                        <img :src="imageUrl || defaultImage" alt="Profile Picture" class="profile-img" />

                        <input type="file" @change="handleImageUpload" accept="image/*" class="file-input" />
                        <p v-if="errors.profile_picture" class="error-message">{{ errors.profile_picture }}</p>
                    </div>
                    

                </div>

                <div class="form-info">
                    
                    <div class="input-box">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" placeholder="Nome" v-model="name" class="base-input"/>
                    </div>

                    <div class="error">
                        <p v-if="errors.name" class="error-message">{{ errors.name }}</p>
                    </div>

                    <div class="input-box">
                        <i class="fa-solid fa-phone"></i>
                        <input type="text"  placeholder="Telefone" v-model="phone" class="base-input"/>
                    </div>

                    <div class="error">
                        <p v-if="errors.phone" class="error-message">{{ errors.phone }}</p>
                    </div>

                    <div class="input-box">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" placeholder="E-mail" v-model="email" class="base-input"/>
                    </div>
                    <div class="error">
                        <p v-if="errors.email" class="error-message">{{ errors.email }}</p>
                    </div>

                </div>

                <div class="btn-box">
                    <BaseButton class="base-button" type="submit">Salvar</BaseButton>
                </div>
            </form>
        </div>
    </section>
</div>
</template>

<script>

    import Navbar from '../../components/NavBar.vue';
    import SideBar from '../../components/SideBar.vue';
    import BaseButton from '../../components/BaseButton.vue';
    import ContactNavbar from '../../components/ContactNavbar.vue';
    import api from '../../services/apiService';
    import defaultImage from '../../assets/img/user.png';

    /////FNCIANDNDO

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
                defaultImage ,
                errors: {
                    "name": '',
                    "phone": '',
                    "email": '',
                    "profile_picture": ''
                }
            };
        },
        methods: {

            handleImageUpload(event) {
                const file = event.target.files[0];
                if (file) {
                    this.file = file;
                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = (e) => {
                        this.imageUrl = e.target.result;
                    };
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
                    // this.$emit('file-selected', this.file);
                }
                // for (let [key, value] of formData.entries()) {
                //     console.log(key, value);
                // }
                try {
                    const token = localStorage.getItem('authToken');
                    await api.post('/contacts', formData, {
                        headers: {
                            
                            'Content-Type': 'multipart/form-data',
                        }
                    });
                    
                    this.$router.push('/home');
                    
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


.master {
    display: flex;
    flex: 1;
    margin-top: 60px;
    justify-content: flex-start;
    height: 100vh;
    overflow: 1;
}

.error {
    display: block;
    p {

        color: red;
    }
}

.content {  
    height: 100%;
    display: flex;
    flex-direction: column;
    margin-left: 220px;
    margin-right: 10px;
    flex: 1;
    padding: 0;
    background-color: #f8f9fa;
    border-radius: 12px;
    margin-bottom: 8px;
    overflow: hidden;
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
    position: sticky; 
    top: 0;
    color: #000000;
    padding: 0px;
    padding-left: 0px;
    z-index: 20;
}

.navbar-content {
    margin-top: 50px;
    color: #000000;
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
    margin-bottom: 20px;
    margin-top: 20px;
}

.input-box i {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
}


.base-input {
    width: 70vh;
    height: 45px;
    margin-bottom: 3px; 
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
    margin-top: 20px;
}

@media screen and (max-width: 1040px) {
    .master {
        width: 100%;
        margin-top: 0;
    }
    .content {
        max-width: 100%;
        margin: 0;
        border-radius: 0;
    }
    .form-container {
        padding: 0;
    }
    .input-box {
        max-width: 100%;
        i {
            display: none;
        }
    }
    .base-button {
        font-size: 20px;
    }
    .btn-box {
        display: flex;
        justify-content: flex-end;
        align-items: flex-end;
        width: 90%;
        
    }
    .base-input {
        width: 95%;
        
        max-width: 100%;
    }

    .form-info {
        width: 100%;
        max-width: 100%;
    }

    .form-box {
        display: flex;
        align-items: center;
        max-width: 100%;
    }
    i {
        display: none;
    }
}
</style>