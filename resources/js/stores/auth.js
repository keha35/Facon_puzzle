import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const useAuthStore = defineStore('auth', () => {
  // État
  const user = ref(null)
  const token = ref(localStorage.getItem('auth_token'))

  // Getters
  const isAuthenticated = computed(() => !!token.value)
  const userFullName = computed(() => user.value ? `${user.value.firstName} ${user.value.lastName}` : '')

  // Actions
  function setToken(newToken) {
    token.value = newToken
    if (newToken) {
      localStorage.setItem('auth_token', newToken)
    } else {
      localStorage.removeItem('auth_token')
    }
  }

  function setUser(userData) {
    user.value = userData
  }

  async function login(credentials) {
    try {
      // Ici, nous simulerons une requête API
      const response = await fetch('/api/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(credentials),
      })

      if (!response.ok) {
        throw new Error('Échec de la connexion')
      }

      const data = await response.json()
      setToken(data.token)
      setUser(data.user)

      return true
    } catch (error) {
      console.error('Erreur de connexion:', error)
      return false
    }
  }

  function logout() {
    setToken(null)
    setUser(null)
  }

  // Vérification du token au démarrage
  async function checkAuth() {
    if (token.value) {
      try {
        const response = await fetch('/api/user', {
          headers: {
            'Authorization': `Bearer ${token.value}`
          }
        })

        if (response.ok) {
          const userData = await response.json()
          setUser(userData)
        } else {
          logout()
        }
      } catch (error) {
        console.error('Erreur de vérification du token:', error)
        logout()
      }
    }
  }

  return {
    // État
    user,
    token,
    // Getters
    isAuthenticated,
    userFullName,
    // Actions
    login,
    logout,
    setUser,
    setToken,
    checkAuth
  }
}) 