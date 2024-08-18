<template>
  <Navbar />
  <div class="main">
    <SideBar />
    <section class="content">
      <ListingComponent text="Contatos" :headers="headers" :items="items"/>
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
  components: {
    Navbar,
    SideBar,
    ListingComponent,
    AddButton
  },
  data() {
    return {
      headers: ['Nome', 'Número do telefone', 'Email', ],
      items: []
    };
  },
  mounted() {
    this.fetchContacts(); // Chama fetchContacts quando o componente é montado
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
        this.items = response.data.contacts;
      } catch (error) {
        console.error('erro ao buscar contatos:', error);
      }
    }
  }

}
</script>



<style scoped>



.main {
  display: flex;
  flex: 1;
  margin-top: 60px; /* Espaço para a altura da navbar */
}


.content {
  margin-left: 280px; /* Largura da sidebar */
  margin-right: 10px;
  flex: 1;
  padding: 0; /* Espaçamento interno */
  background-color: #f8f9fa; /* Cor de fundo para a área de conteúdo */
  border-radius: 12px;
  margin-bottom: 8px;
  height: 100%;
  min-height: 100%;
}

</style>
