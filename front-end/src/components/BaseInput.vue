<template>

  <input 
    :type="type" 
    :placeholder="placeholder" 
    :value="value" 
    :class="inputClass"
  />
  
</template>

<script>
  export default {
    props: {
      type: {
        type: String,
        default: 'text' 
      },
      placeholder: {
        type: String,
        default: ''
      },
      value: {
        type: String,
        default: ''
      },
      inputClass: {
        type: String,
        default: ''
      }
    }
  }
</script>

<style scoped>

  input {
    
    width: 480px;
    height: 65px;
    margin-bottom: 45px; 
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
</style>
