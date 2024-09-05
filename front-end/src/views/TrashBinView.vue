<template>
  <div class="main">
    <section class="content">
      
      <ListingComponent text="Lixeira" class="listingComp" :headers="headers" :contacts="contacts"/>
      
    </section>
  </div>
</template>

<script>
  import ListingComponent from '../components/ListingComponent.vue';

  import api from '../services/apiService';
  import { useToastStore } from '../stores/toast';

  export default {

    components: {
      
      ListingComponent,

    },

    data() {
      return {
        headers: ['Nome', 'Número de telefone', 'Email', ],
        contacts: [],
      };
    },
    
    setup() {

      const errorStore = useToastStore();
      
      return { errorStore };
    },

    mounted() {

      this.fetchContacts();

    },

    methods: {
      async fetchContacts() {
        try {
          
          const response = await api.get('/trash-bin');
          this.contacts = response.data.contacts;

        } catch (error) {
          
          const errorMessage = error.response.errorMsg;
          
          const toastStore = useToastStore();
          toastStore.errorToast(errorMessage);
          
        }
      },
      
    }

  }
</script>



<style scoped>



.main {
  display: flex;
  flex: 1;
  margin-top: 80px; 
  overflow: hidden;
}

.toast-container {
  position: absolute;
  top: 10px;
  right: 10px;
  z-index: 9999;
}

.toast {
  margin: 0;
}

.content {
  margin-left: 220px;
  margin-right: 10px;
  flex: 1;
  padding: 0; 
  background-color: #f8f9fa; 
  border-radius: 12px;
  margin-bottom: 8px;
  height: 100%;
  min-height: 100%;
}
@media screen and (max-width: 1040px){
  
  .main {
    margin: 0;
  }
  
  .content {
    margin: 0; 
    border-radius: 0;
  }

}
</style>
