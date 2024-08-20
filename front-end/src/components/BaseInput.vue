<template>
  <input 
    v-model="inputValue"
    @input="$emit('update:modelValue', inputValue)"
  />
</template>

<script>
export default {
  data() {
    return {
      inputValue: ''
    };
  },
  watch: {
    modelValue(newValue) {
      this.inputValue = newValue;
    }
  }
}
</script>


<style scoped>

  input {
    
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
