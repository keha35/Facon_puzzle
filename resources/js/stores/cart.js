import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const useCartStore = defineStore('cart', () => {
  // État
  const items = ref(JSON.parse(localStorage.getItem('cart_items') || '[]'))

  // Getters
  const itemCount = computed(() => items.value.reduce((total, item) => total + item.quantity, 0))
  const total = computed(() => items.value.reduce((sum, item) => sum + item.price * item.quantity, 0))

  // Actions
  function saveToLocalStorage() {
    localStorage.setItem('cart_items', JSON.stringify(items.value))
  }

  function addItem(item) {
    const existingItem = items.value.find(i => i.id === item.id)
    if (existingItem) {
      existingItem.quantity += 1
    } else {
      items.value.push({ ...item, quantity: 1 })
    }
    saveToLocalStorage()
  }

  function removeItem(itemId) {
    const index = items.value.findIndex(item => item.id === itemId)
    if (index !== -1) {
      items.value.splice(index, 1)
      saveToLocalStorage()
    }
  }

  function updateQuantity(itemId, quantity) {
    const item = items.value.find(i => i.id === itemId)
    if (item) {
      item.quantity = Math.max(0, quantity)
      if (item.quantity === 0) {
        removeItem(itemId)
      } else {
        saveToLocalStorage()
      }
    }
  }

  function clearCart() {
    items.value = []
    saveToLocalStorage()
  }

  return {
    // État
    items,
    // Getters
    itemCount,
    total,
    // Actions
    addItem,
    removeItem,
    updateQuantity,
    clearCart
  }
}) 