<template>
<div class="master">
    <section class="content">
        <div class="form-container">

            <ContactNavbar title="Editar contato" />

            <form @submit.prevent="add" class="form-box">

                <div class="profile-picture">

                    <div class="image-container">
                        <img :src="imageUrl || defaultImage" alt="Profile Picture" class="profile-img" />
                        <input type="file" @change="handleImageUpload" accept="image/*" class="file-input" />
                    </div>
                    <p v-if="!imageUrl">Escolha uma imagem (max:2048KB)</p>

                </div>

                <div class="form-info">
                    <input type="hidden" v-model="contact.id">
                    <div class="input-box">
                        <div class="inp">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" placeholder="Nome"  v-model="contact.name" class="base-input"/>
                        </div>

                        <div class="error">
                            <p v-if="errors.name" class="error-message">{{ errors.name }}</p>
                        </div>
                    </div>

                    

                    <div class="input-box">
                        <div class="inp">
                            <i class="fa-solid fa-phone"></i>
                            <input type="text" placeholder="Telefone" v-model="contact.phone" class="base-input"/>
                            
                        </div>
                        <div class="error">
                            <p v-if="errors.phone" class="error-message">{{ errors.phone }}</p>
                        </div>

                    </div>
                    
                    
                    <div class="input-box">
                        
                        <div class="inp">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" placeholder="E-mail" v-model="contact.email" class="base-input"/>
                        </div>    
                        <div class="error">
                            <p v-if="errors.email" class="error-message">{{ errors.email }}</p>
                        </div>

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

    import BaseButton from '../../components/BaseButton.vue';
    import ContactNavbar from '../../components/ContactNavbar.vue';
    import api from '../../services/apiService';
    import defaultImage from '../../assets/img/user.png';


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
                errors: {
                    "name": '',
                    "phone": '',
                    "email": '',
                    "profile_picture": ''
                },
                imageUrl: null,
                file: null,
            };

    
        },
        computed: {
            imageUrl() {
                return this.contact?.profile_picture 
                ? `${api.defaults.imgURL}/${this.contact.profile_picture}` 
                : defaultImage;
            }
        },

        async mounted() {
            await this.fetchContact(); 
        },

        methods: {
            handleImageUpload(event) {
                const file = event.target.files[0];
                if (file) {
                    this.file = file;
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.imageUrl = e.target.result;
                        console.log("caminho", this.imageUrl)
                    };
                    console.log("arquivo", this,file)
                    reader.readAsDataURL(file);
                } else {
                    this.imageUrl = ''; 
                }
            },
            async fetchContact() {
                const id = this.$route.params.id; 
                    
                try {
                    const response = await api.get(`/contacts/${id}`, );

                    this.contact = response.data.contact
                
                } catch (error) {
                    console.error('Error fetching contact:', error);
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
                try {
                    const id = this.contact.id; 
                    await api.post(`/contacts/${id}`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    });
                    
                    this.$router.push('/home');
                } catch (error) {
                    if (error.response.data.errors) {
                        this.errors = error.response.data.errors;
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
    align-items: flex-start;
    font-size: 30px;
    margin-bottom: 0px;
    margin-top: 20px;
    flex-direction: column;
    margin-bottom: 3px;
    
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
.error {
    min-height: 30px;
    display: flex;
    justify-content: flex-start;
    align-items: flex-start;
    margin-left: 10px;
    color: transparent;
    p {
        margin-top: 0px;
        font-size: 16px;
        color: red;
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
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-bottom: 20px;
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

.error {
    position: relative;
    margin-left: 10px;
    p {
        color: red;
    }
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

    .btn-box {
        display: flex;
        justify-content: flex-end;
        align-items: flex-end;
        width: 90%;
        
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