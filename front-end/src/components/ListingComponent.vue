<template>
  <div class="item-list">
    <div class="navbar">
      <div class="navbar-content">
        <span>
          {{ text }} ({{ items.length }})
        </span>
      </div>
    </div>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th v-for="(header) in headers" >{{ header }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item) in items">
          <td>{{ item.name }}</td>
          <td>{{ item.email }}</td>
          <td>{{ item.phone }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'ListingComponent',
    props: {
      text: {
        type: String,
        default: ''
      },
      items: {
        type: Array,
      },
      headers: {
        type: Array,
      }
    },
  }
</script>

<style scoped>
.item-list {
  display: flex;
  flex-direction: column;
  height: 100%;
}

.navbar {
  position: sticky;
  top: 0;
  background-color: #ffffff;
  color: #000000;
  padding-left: 0px;
  padding-bottom: 0;
  border-radius: 12px 12px 0 0;
  z-index: 20;
}

.navbar-content {
  margin-top: 20px;
  color: #000000;
  font-size: 27px;
  padding-left: 30px;
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

th, td {
  padding: 10px;
  text-align: left;
  border-bottom: 1px solid #ddd;
  border: none;
  padding-left: 30px;
}

th {
  background-color: #ffffff;
  font-weight: normal;
  padding-left: 30px;
}



tbody tr:hover {
  background-color: #f1f1f1;
}
</style>
