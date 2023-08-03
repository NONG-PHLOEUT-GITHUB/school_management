import { defineStore } from 'pinia';
import Cookies from 'js-cookie';

export const useCookieStore = (key, expires = 14) => defineStore({
  id: 'CookieStore',
  state: () => ({ value: null }),
  actions: {
    setValue(value) {
      Cookies.set(key, value, { expires });
      this.value = value;
    },
    clearValue() {
      Cookies.remove(key);
      this.value = null;
    },
  },
  getters: {
    getValue() {
      const value = Cookies.get(key);
      return value ? value : null;
    },
  },
});

export default useCookieStore('access_token');