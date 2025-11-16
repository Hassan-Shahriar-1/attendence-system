import { defineStore } from 'pinia'
import axios from 'axios';

export const UserStore = defineStore('UserStoreId', {
    state: () => ({
        token: localStorage.getItem('token') || 0,
        user: JSON.parse(localStorage.getItem('user')) || null
    }),

    getters: {
        getToken: (state) => state.token,
        getUser: (state) => state.user
    },

    actions: {
        setToken(token){
            this.token = token
            localStorage.setItem('token', token)
        },
        async setUser(user){
            this.user = user
            localStorage.setItem('user', JSON.stringify(user))
        },
        async logout(){
            this.token = 0
            this.user = null
            localStorage.removeItem('token')
            localStorage.removeItem('user')
            await axios.post('/admin/logout')
        },
    }
});