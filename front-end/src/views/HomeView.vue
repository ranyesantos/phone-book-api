<template>
  <Navbar />
  <div class="main">
    <SideBar class="sidebar"/>
    <section class="content">
      <ListingComponent text="Contatos" class="listingComp" :headers="headers" :contacts="contacts"/>
      <AddButton redirectUrl="/new" />
    </section>
  </div>
</template>

<script>
import ListingComponent from '../components/ListingComponent.vue';
import Navbar from '../components/NavBar.vue';
import SideBar from '../components/SideBar.vue';
import AddButton from '../components/AddButton.vue';
import api from '../services/apiService';

export default {
  props: ['id'],
  components: {
    
    Navbar,
    SideBar,
    ListingComponent,
    AddButton
  },

  data() {
    return {
      headers: ['Nome', 'Número de telefone', 'Email', ],
      contacts: []
      
    };
  },

  mounted() {
    this.fetchContacts();
  },

  methods: {
    async fetchContacts() {
      try {
        const token = localStorage.getItem('authToken'); 
        const response = await api.get('/contacts', {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });
        this.contacts = response.data.contacts;
      } catch (error) {
        console.error('erro ao buscar contatos:', error);
        return;
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
