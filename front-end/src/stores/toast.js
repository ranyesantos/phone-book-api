import { defineStore } from 'pinia';
import { useToast } from 'vue-toastification'

const toast = useToast()

export const useToastStore = defineStore('message', {
  state: () => ({
    errorMessage: null,
    successMessage: null,
  }),
  actions: {
    errorToast(message) {
      this.errorMessage = message;
      toast.error(this.errorMessage);
    },
    successToast(message) {
      this.successMessage = message;
      toast.success(this.successMessage);
    },
  },
  getters: {
    isError: (state) => !!state.errorMessage,
  },
});
