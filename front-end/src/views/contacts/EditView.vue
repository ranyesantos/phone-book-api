<template>
<div class="master">
    <section class="content">
        <div class="form-container">

            <ContactNavbar title="Editar contato" />

            <form @submit.prevent="add" class="form-box">

                <div class="profile-picture">

                    <div class="image-container">

                        <img :src="imageUrl ||imageUrlExistent || defaultImage" alt="Profile Picture" class="profile-img" />
                        <input type="file" @change="handleImageUpload" :key="resetFileKey" accept="image/*" class="file-input" />
                    </div>

                    <div class="pic-actions">
                        <button v-if="imageUrl || imageUrlExistent" @click="removeImage" class="remove-pic-btn"><i class="fa-solid fa-minus"></i></button>
                    </div>

                </div>

                <div class="form-info">
                    <input type="hidden" v-model="contact.id">
                    <div class="input-box">
                        <div class="inp">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" placeholder="Nome"  v-model="contact.name" class="base-input"/>
                        </div>

                    </div>

                    

                    <div class="input-box">
                        <div class="inp">
                            <i class="fa-solid fa-phone"></i>
                            <input type="text" placeholder="Telefone" v-model="contact.phone" class="base-input"/>
                            
                        </div>

                    </div>
                    
                    
                    <div class="input-box">
                        
                        <div class="inp">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" placeholder="E-mail" v-model="contact.email" class="base-input"/>
                        </div> 

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
                contact: {
                    id: '',
                    name: '',
                    phone: '',
                    email: '',
                }, 
                errors: [],
                imageUrl: null,
                file: null,
                defaultImage,
                removePfp: false,
                resetFileKey: Date.now()
            };

    
        },
        computed: {
            imageUrlExistent() {
                return this.contact?.profile_picture 
                ? `${api.defaults.imgURL}/${this.contact.profile_picture}` 
                : false;
            }
        },

        async mounted() {
            await this.fetchContact(); 
        },

        methods: {
            handleImageUpload(event) {
                const file = event.target.files[0];
                if (file) {
                    this.removePfp = false;
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

            async removeImage() {
                
                this.removePfp = true; 
                this.contact.profile_picture = '';
                this.imageUrl = ''; 
                this.file = '';
                this.resetFileKey = Date.now();
                
            },

            async fetchContact() {
                const id = this.$route.params.id; 
                    
                try {
                    const response = await api.get(`/contacts/${id}`, );

                    this.contact = response.data.contact
                
                } catch (error) {
                    if (error.response && error.response.data) {
                      
                      const errorMessage = error.response.data.message || error.response.data.errorMsg;
                      
                      const toastStore = useToastStore();
                      toastStore.errorToast(errorMessage);
                      
                      this.$router.push('/home');
                    } 
                  
                  this.$router.push('/home');
                }
            },
            
            async add() {
                if (this.contact.email === "null"|| this.contact.email === null){
                    this.contact.email = '';
                }   
            
                const formData = new FormData();
                formData.append('name', this.contact.name);
                formData.append('phone', this.contact.phone);
                formData.append('email', this.contact.email);

                if (this.file) {
                    formData.append('profile_picture', this.file);
                }
                
                if (this.removePfp) {
                    formData.append('remove_pfp', true);
                }

                try {

                    const id = this.contact.id; 
                    const response = await api.post(`/contacts/${id}`, formData, {
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

                    if (error.response.data.errors) {
                        this.errors = Object.values(error.response.data.errors).flat();
                    } 
                }
            },
            
        },
        
        
    }
</script>

<style>

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

.inp {
    display: flex;
    min-width: 100%;
    min-height: 30%;
    flex-direction: row;
    i{
        margin-right: 20px;
    }
}

.master {
    display: flex;
    flex: 1;
    margin-top: 60px; 
    justify-content: flex-start;
    height: 100vh;
    overflow-y: 1;
    overflow-x: hidden;
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

li {
    color: red;
    font-size: 18px;
}

@media screen and (max-width: 1040px) {
    .master {
        width: 100%;
        margin-top: 0;
    }

    li {
        color: red;
        font-size: 14px;
    }
    .content {
        width: 100%;
        margin: 0;
        border-radius: 0;
    }
    .input-box i {
        display: none;
    }

    .form-container {
        padding: 0;
        width: 100%;
    }

    .inp {
        display: flex;
        justify-content: center;
        width: 100%;
    }
    
    .input-box {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        font-size: 30px;
        margin-bottom: 20px;
        margin-top: 20px;
    }


    .base-button {
        font-size: 18px;
    }

    .base-input {
        width: 95%;
        max-width: 100%;
    }

    .form-info {
        width: 100%;
        max-width: 100%;
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

    .file-input {
        max-width: 70px;
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