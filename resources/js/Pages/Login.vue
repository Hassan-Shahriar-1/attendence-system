  <template>
                <div class="login-container">
                    <div class="login-card">
                        <h1>Login</h1>
                        
                        <form @submit.prevent="handleLogin">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    placeholder="Enter your email"
                                    required
                                />
                            </div>

                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input
                                    id="password"
                                    v-model="form.password"
                                    type="password"
                                    placeholder="Enter your password"
                                    required
                                />
                            </div>

                            <button type="submit" :disabled="loading">
                                {{ loading ? 'Logging in...' : 'Login' }}
                            </button>

                            <p v-if="error" class="error-message">{{ error }}</p>
                        </form>
                    </div>
                </div>
            </template>

<script setup>
            import { reactive, ref } from 'vue';
            import { useRouter } from 'vue-router';
            import axios from 'axios';
            import { UserStore } from '../stores/UserStore';
            const form = reactive({
              email: '',
              password: '',
            });

            const loading = ref(false);
            const error = ref('');
            const router = useRouter();
            const authStore = UserStore();

    async function handleLogin() {
              loading.value = true;
              error.value = '';

              try {
                const response = await axios.post('/api/login', form);
                
                authStore.setUser(response.data.data.user);
                authStore.setToken(response.data.data.token);
                router.push('/');
              } catch (err) {
                error.value = err.response?.data?.message || 'Login failed';
              } finally {
                loading.value = false;
              }
            }
            </script>

<style scoped>
            .login-container {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                background: #f5f5f5;
            }

            .login-card {
                background: white;
                padding: 40px;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                width: 100%;
                max-width: 400px;
            }

            h1 {
                text-align: center;
                margin-bottom: 30px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            label {
                display: block;
                margin-bottom: 5px;
                font-weight: 500;
            }

            input {
                width: 100%;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 4px;
                font-size: 14px;
            }

            button {
                width: 100%;
                padding: 10px;
                background: #007bff;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
            }

            button:disabled {
                opacity: 0.6;
            }

            .error-message {
                color: red;
                margin-top: 15px;
                text-align: center;
            }
</style>