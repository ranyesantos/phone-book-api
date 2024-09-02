<template>
<div class="master">
    <section class="content">
        <div class="form-container">

            <ContactNavbar title="Adicionar Contato" />

            <form @submit.prevent="add" class="form-box">

                <div class="profile-picture">

                    <div class="image-container">

                        <img :src="imageUrl || defaultImage" alt="Profile picture" class="profile-img" />
                        <input type="file" @change="handleImageUpload" :key="resetFileKey" accept="image/*" class="file-input" />

                    </div>

                    <div class="pic-actions">
                        <button v-if="imageUrl" @click="removeImage" class="remove-pic-btn"><i class="fa-solid fa-minus"></i></button>
                    </div>

                </div>

                <div class="form-info">
                    
                    <div class="input-box">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" placeholder="Nome" v-model="name" class="base-input"/>
                    </div>

                    <div class="input-box">
                        <i class="fa-solid fa-phone"></i>
                        <input type="text"  placeholder="Telefone" v-model="phone" class="base-input"/>
                    </div>

                    <div class="input-box">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="text" placeholder="E-mail" v-model="email" class="base-input"/>
                    </div>

                </div>

                <div class="form-footer">
    
                    <div class="btn-box">
                        <BaseButton class="base-button" type="submit">Salvar</BaseButton>
                    </div>
    
                    <div class="errors-mobile">
                        <div v-if="errors.length" class="error-messages">
                            <ul>
                                <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </section>
</div>
</template>

<script>

    import BaseButton from '../../components/BaseButton.vue';
    import ContactNavbar from '../../components/ContactNavbar.vue';
    import api from '../../services/apiService';
    import defaultImage from '../../assets/img/user.png';
    import { useToastStore } from '../../stores/toast';

    export default {
        components: {
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
                defaultImage,
                removePfp: false,
                resetFileKey: Date.now(),
                errors: []
            };
        },
        methods: {

            handleImageUpload(event) {
                const file = event.target.files[0];
                if (file) {
                    this.file = file;
                    this.removePfp = false; 
                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = (e) => {
                        this.imageUrl = e.target.result;
                    };
                } else {
                    this.imageUrl = ''; 
                }
            },
            
            removeImage() {
                
                this.removePfp = true; 
                this.imageUrl = ''; 
                this.file = '';
                this.resetFileKey = Date.now();
                
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

                    const response = await api.post('/contacts', formData, {
                        headers: {
                            
                            'Content-Type': 'multipart/form-data',
                        }
                    });
                  
                    const successMessage = response.data.message;
                    
                    const toastStore = useToastStore();
                    toastStore.successToast(successMessage);

                    this.$router.push('/home');
                    
                    
                } catch (error) {
                    
                    if (error.response && error.response.data && error.response.data.errorMsg) {                    
                        const errorMessage = error.response.data.errorMsg;
                                        
                        const toastStore = useToastStore();
                        toastStore.errorToast(errorMessage);
                        
                    }
                    
                    if (error.response && error.response.data && error.response.data.errors) {
                        this.errors = Object.values(error.response.data.errors).flat();
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

.form-footer {
    display: flex;
    justify-content: space-between;
    flex-direction: row;
    align-items: center;
    box-sizing: border-box;
}

.btn-box {
    display: flex;
    height: 100%;
    justify-content: flex-end;
    align-items: flex-start;
    margin-left: 10px;
    margin-right: 80px;
}

.errors-mobile {
    margin-left: 50px;
    min-width: 215px;
    display: inline-block;
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
    position:relative;
    display: flex;
    flex-direction: row;
    align-items: center;
    max-height: 160px;
    min-height: 160px;
}

.pic-actions {
    position: absolute;
    top: 104px;
    left: 115px;
}

.remove-pic-btn {
    background-color: red;
    color: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    i {
        font-size: 30px;
    }
}

.image-container {
    position: relative;
    margin-bottom: 0px;
}

.profile-img {
    width: 150px; 
    height: 150px;
    border-radius: 50%;
    border: 2px solid #ddd;
}

.file-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 150px; 
    height: 150px;
    opacity: 0; 
    cursor: pointer; 
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

li {
    color: red;
    font-size: 18px;
}

p {
    margin-top: 0px;
    color: #888; 
}

@media screen and (max-width: 1040px) {
    
    li {
        color: red;
        font-size: 14px;
    }
    
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
    
    .form-footer {
        display: flex;
        justify-content: space-between;
        flex-direction: row-reverse;
        align-items: center;
        box-sizing: border-box;
        width: 100%;
    }

    .btn-box {
        display: flex;
        height: 100%;
        justify-content: flex-end;
        align-items: flex-start;
        margin-left: 10px;
        margin-right: 10px;
    }

    .errors-mobile {
        margin-left: 20px;
        min-width: 215px;
        display: inline-block;
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
        margin-top: 0;
        display: flex;
        align-items: center;
        max-width: 100%;
        height: 100%;
        overflow-x: hidden;
    }

    li {
        color: red;
    }

    i {
        display: none;
    }
}
</style>