<template>

    <div class="logout-btn">
        
        <button @click="logout">
            <i class="fa-solid fa-right-from-bracket"></i>
            Logout
        </button>
    </div>

</template>

<script>
    import api from '../services/apiService';

    export default {
    name: 'logoutButton',
    props: {
    text: {
      type: String,
      default: 'Logout' // Define um valor padrão caso a prop não seja passada
    }
  },
    methods: {
        async logout() {
            try {
           
                const token = localStorage.getItem('authToken');
                const response = await api.post('/logout', null, { 
                headers: {
                    Authorization: `Bearer ${token}` 
                }
                });
                
               
                if (response.status === 200) {
                console.log('Logout successful');
                
                localStorage.removeItem('user');
                localStorage.removeItem('authToken');
                
               
                this.$router.push({ name: 'login' });
                }
            } catch (error) {
                console.log('ta errado2')
            }
        },
    }
};
</script>


<style>
.logout-btn {
    
    display: flex;
    align-items: center;
    i {
        transform: scaleX(-1);
        transition: background-color 0.3s;
    }
    a {
        padding-left: 10px;
        text-decoration: none;
        color: white;
    }
    a:hover {
        color: rgb(172, 170, 170);
        background-color: transparent
    }
}
.logout-btn button {
    display: flex;
    align-items: center;
    background: none;
    border: none;          
    color: inherit;   
    padding: 0;        
    font: inherit;
    cursor: pointer;
    display: flex;
    align-items: center;
    i {
        transform: scaleX(-1);
        transition: background-color 0.3s;
        margin-right: 8px;
    }
    

}



</style>