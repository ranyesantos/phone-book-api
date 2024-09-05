<template>
  <div class="item-list">
    <div class="header-listing">
      <div class="header-content">
          <div class="header-inner" >

            <div class="header-text">

              {{ text }} ({{ contacts.length }})
    
            </div>

            <div class="th-box">
              <h1 class="nav-h1" v-for="(header, index) in headers":key="index">{{ header }}</h1>
            </div>

            <logoutButton class=".logout-btn" />

          </div>
          
      </div>
    </div>

    <div class="table-container"> 
      <table>
        <tbody>
          <tr v-for="(contact) in contacts" :key="contact.id" @click="viewDetails(contact.id)">
            <div class="profile-box">
              <span><img :src="imageUrl(contact.id)" alt="Profile Picture" class="profile-img"/></span>
              <td class="name-cell">{{ contact.name }}</td>
            </div>


            <td class="phone-cell">
              {{ formatPhoneNumber(contact.phone) }}
            </td>


            <td class="email-cell">{{ contact.email }}</td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</template>

<script>

  import api from '../services/apiService';
  import defaultImage from '../assets/img/user.png';
  import logoutButton from './logoutButton.vue'

  export default {
    

    name: 'ListingComponent',
    components: {
      logoutButton
    },

    props: {
      text: {
        type: String,
        default: ''
      },
      contacts: {
        type: Array,
        default: () => [] 
      },
      headers: {
        type: Array,
        default: () => [] 
      },
    },

    data() {
      return {
        defaultImage
      };
    },

    computed: {
      imageUrl() {
        return (id) => {
          const contact = this.contacts.find(contact => contact.id === id);
          return contact?.profile_picture 
            ? `${api.defaults.imgURL}/${contact.profile_picture}` 
            : this.defaultImage;
        };
      },
      
    },
    
    methods: {
      
      formatPhoneNumber(phone) {
        phone = phone.toString().replace(/\D/g, '');

        if (phone.length === 11) {
          return phone.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
        } else if (phone.length === 10) {
          return phone.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
        } else {
          return phone;
        }
      },
      
      viewDetails(id) {

        const contact = this.contacts.find(contact => contact.id === id);
        console.log(contact)

        if(contact.deleted_at != null){
          this.$router.push({ name: 'showTrashedContact', params: { id }})   
        } else {
          this.$router.push({ name: 'showContact', params: { id }})
        }

      }
    }
    
  };

</script>

<style scoped>


.item-list {
  display: flex;
  flex-direction: column;
  height: 100%;
}
span {
  width: 60px;
  height: 60px;
}
.profile-box {
  display: flex;
  align-items: center;
  width: 30px;
  margin-left: 10px;
}
.profile-img {
  width: 50px; 
  height: 50px;
  border-radius: 50%; 
  object-fit: cover;
  border: 2px solid #ddd;
}

.image-cell {
  position: relative;
  margin-bottom: 0px;
}

.name-cell {
  min-width: 300px;
  padding-left: 10px;
}

.nav-h1 {
  padding: 10px;
  margin: 5px;
}

.th-box {
  display: flex;
  justify-content: space-between;
  h1{
    font-weight: normal;
    font-size: 22px;
  }
}

.header-listing {
  width: 100%;
  display: flex;
  justify-content: space-between;
  top: 0;
  background-color: #ffffff;
  color: #000000;
  padding-left: 0px;
  padding-bottom: 0;
  border-radius: 12px 12px 0 0;
  z-index: 20;
}

.header-content {
  max-height: 120px;
  margin-top: 20px;
  color: #000000;
  font-size: 27px;
  padding-left: 30px;
  width: 80%;
}

.table-container {
  flex: 1;
  margin-top: 0px;
  overflow-y: auto;
 
}

table {
  width: 100%;
  border-collapse: collapse;
  
}

thead {
  z-index: 10;
  border: none;
  box-shadow: 0 1 px 1px rgba(0, 0, 0, 0.1);
  width: 100%;
    
}

td {
  padding: 10px;
  border: none;
  padding-left: 30px;
  cursor: pointer;
  max-width: 30px;
  overflow: hidden; 
  text-overflow: ellipsis;
  white-space: nowrap;
}

.logout-btn {
  display: none;
}

th {
  background-color: #ffffff;
  font-weight: normal;
  padding-left: 30px;
  cursor: default;
}

.phone-cell {
  padding-left: 0px;
  padding-right: 40px;
  text-align: center;
}
.email-cell{
  text-align: center;
  padding-left: 0px;
  padding-right: 30px;
  min-width:30px;
} 

tbody tr:hover {
  background-color: #f1f1f1;
}

@media screen and (max-width: 1040px) {
  .email-cell, .phone-cell {
    display: none;
  }

  .nav-span {
    display: flex;
  }

 
  .name-cell{
    font-size: 16px;
   
    padding: 5px; 
  }
  .th-box {
  display: none;
  }

  .logout-btn {
    display: flex;
    color: #000000;
    font-size: 20px;
  }


  .header-listing {
    height: 80px;
    background: rgb(255, 255, 255);
    border-radius: 0;
  }

  .header-text {
    font-size: 21px;
  }

  .header-inner {
    width: 100%;
    justify-content: space-between;
    flex-direction: row;    
    display: flex;
  }

  .header-content {
    
    margin-bottom: 20px;
  }
  .profile-box {
    display: flex;
    align-items: center;
    justify-content: flex-start;
  }
  tr {
    box-shadow: 0px 3px 3px rgba(155, 155, 155, 0.1); 
    border-bottom: 0.1px solid #ddd;
  }
  
}
</style>
