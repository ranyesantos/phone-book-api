<template>
    <div class="master">
        <section class="content">
            <div v-if="contact" class="contact-container" >
                <div class="contact-header">
                    <ContactNavbar />
                    <div class="img-name">
                        <div class="image-container">
                            <img :src="imageUrl || defaultImage" alt="Profile Picture" class="profile-img" />
                        </div>
                        <div class="name-info">
                            <h1>{{ contact.name }}</h1>
                        </div>
                    </div>
                </div>

                <div class="contact-content">
                    <div class="contact-box">
                        <div class="top-info">
                            <h2>Detalhes do contato</h2>
                            <div class="actions">

                                <a @click="showRestoreModal = true">
                                    <i class="fa-solid fa-trash-can-arrow-up"></i>
                                </a>

                                <a  @click="showModal = true">
                                    <i class="fa-solid fa-trash"></i>
                                </a>

                                <ModalDelete :show="showModal" @confirm="deleteBtn" @cancel="showModal = false"> 
                                    <template v-slot:message>
                                        Tem certeza de que deseja excluir o contato permanentemente?
                                    </template>
                                </ModalDelete>

                                <ModalDelete :show="showRestoreModal" @confirm="restoreContact" @cancel="showRestoreModal = false"> 
                                    <template v-slot:title>
                                        Restaurar Contato
                                    </template>
                                    <template v-slot:message>
                                        Tem certeza de que deseja restaurar o contato?
                                    </template>
                                </ModalDelete>

                            </div>
                        </div>
                        <div class="contact-info">
                            <div class="details-info">
                                <i class="fa-solid fa-phone"></i>
                                <h3>{{ formatPhoneNumber(contact.phone) }}</h3>
                            </div>
                            <div class="details-info">
                                <i class="fa-solid fa-envelope"></i>
                                <h3>{{ contact.email }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import ContactNavbar from '../../components/ContactNavbar.vue';
    import defaultImage from '../../assets/img/user.png';
    import ModalDelete from '../../components/Modal.vue';
    import api from '../../services/apiService';
    import { useToastStore } from '../../stores/toast';

    
    export default {
        components: {
            ContactNavbar,
            ModalDelete
        },

        data() {
            return {
                contact: null,
                defaultImage,
                showModal: false,
                showRestoreModal: false,
                contactId: null,
            };
        },
        computed: {
            imageUrl() {
                return this.contact?.profile_picture 
                ? `${api.defaults.imgURL}/${this.contact.profile_picture}` 
                : this.defaultImage;
            }
        },

        async mounted() {
            await this.fetchContact();
        },

        methods: {
            
            async deleteBtn() {

                const id = this.$route.params.id; 
                
                try {

                    const response = await api.delete(`/trash-bin/${id}`);
                    
                    if (response.status == 200){
                        
                        const successMessage = response.data.message;
                        
                        const toastStore = useToastStore();
                        toastStore.successToast(successMessage);


                        this.$router.push('/trash-bin');
                    }

                } catch (error) {
                    
                    const errorMessage = error.response.data.errorMsg || error.response.data.message;
                    
                    const toastStore = useToastStore();
                    toastStore.errorToast(errorMessage);

                    this.$router.push('/trash-bin');
                }
            },
            
            async restoreContact() {

                const id = this.$route.params.id;
                
                try {
                    
                    const response = await api.put(`/trash-bin/${id}`);
                    
                    if (response.status == 200) {
                        const successMessage = response.data.message;

                        const toastStore = useToastStore();
                        toastStore.successToast(successMessage);
                        
                        this.$router.push('/home');
                    }

                } catch (error) {

                    const errorMessage = error.response.data.errorMsg || error.response.data.message;

                    const toastStore = useToastStore();
                    toastStore.errorToast(errorMessage);

                    this.$router.push('/trash-bin');

                }
            },
            
            async fetchContact() {

                const id = this.$route.params.id;
                
                try {
                    const response = await api.get(`/trash-bin/${id}`);
                    this.contact = response.data.contact
                    console.log(contact)
                } catch (error) {
                    if (error.response && error.response.data) {
                        
                        const errorMessage = error.response.data.message || error.response.data.errorMsg;
                        
                        const toastStore = useToastStore();
                        toastStore.errorToast(errorMessage);
                        
                    } 
                    
                }
            },
            
            formatPhoneNumber(phone) {
                phone = phone.toString();
                
                if (phone.length === 11) {
                    return phone.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                    } else if (phone.length === 10) {
                        return phone.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
                    } else {
                    return phone;
                        
                }
            },
        }
    }
</script>


<style>

.master {
    display: flex;
    flex: 1;
    margin-top: 60px; 
    justify-content: flex-start;
    height: 100%;
    overflow: hidden;
}

.top-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 10px;
    margin-right: 4px;
    margin-top: 4px;
}

.actions {
    a {
        text-decoration: none;
        color: black;
    }
    i {
        font-size: 26px;
        margin-right: 9px;
    }
    a:hover {
        background-color: transparent;
        cursor: pointer;
        text-decoration: none;
        color: rgb(87, 85, 85)
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

.contact-container {
    padding-left: 80px;
}

.contact-header {
    display: flex;
    align-items: flex-start;
    flex-direction: column;
    width: 50%;
}


.name-info {
    margin-left: 30px;
}

.profile-picture {
    width: 150px; 
    height: 150px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.image-container {
    position: relative;
    margin-left: 5px;
}

.profile-img {
    width: 150px; 
    height: 150px;
    border-radius: 50%; 
    object-fit: cover;
    border: 2px solid #ddd;
}

.contact-content {
    margin-top: 20px;
    background-color: #f8f9fa;
    display: flex;
    align-items: flex-start;

}

.contact-box {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    background-color: rgb(207, 206, 206);
    width: 50vh;
    height: 150px;
    padding: 9px 26px 5px 26px;
    border-radius: 20px;
    overflow: hidden;
}

.contact-info {
    display: flex;
    flex-direction: column; 
    gap: 10px;
    margin-left: 10px
}

.details-info {
    display: flex;
    align-items: center;
    gap: 10px;
    i {
        font-size: 24px; 
        color: #333;
    }
    h3 {
        margin-bottom: 3px;
    }
    
}

h1, h2, h3 {
    font-weight: normal;
    font-size: 26px;
    overflow-wrap: break-word;
    word-break: break-word;
    
}

h2 {
    margin-bottom: 2px;
    font-size: 20px;
}

h3 {
    margin-left: 8px;
    font-size: 19px;
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
    .contact-content {
        margin-left: 12px;
        margin-right: 12px;
    }
    .contact-box {
        width:100%;
        max-width: 100%;
        padding: 0;
        
    }
    .content {
        overflow-y: auto;
        flex-grow: 1
    }
    .contact-header {
        width: 100%;
    }
    .img-name {
        width: 100%;
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
    }
    .name-info {
        display: flex;
        text-align: start;
        margin-left: 8px;
        h1 {
            font-size: 26px;
        }
    }
    .top-info {
        margin-left: 10px;
        h2 {
            font-size: 21px;
        }
    }

    .contact-info{
        padding: 20px;
        padding-top: 0;
    }

    h3, h2, h1 {
        overflow-wrap: break-word;
        word-break: break-word;
    }

    .image-container {
        margin: 0;
    }

    .profile-img {
        width: 220px; 
        height: 220px;
        border-radius: 50%; 
        object-fit: cover;
        border: 2px solid #ddd;
    }
    .contact-container {
        padding: 0;
        max-width: 100%;
    }
}
</style>