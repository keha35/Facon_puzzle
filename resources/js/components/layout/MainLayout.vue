<template>
  <div class="flex flex-col min-h-screen">
    <TheHeader />
    
    <main class="flex-grow">
      <slot></slot>
    </main>

    <TheFooter />
  </div>
</template>

<script setup>
import TheHeader from './TheHeader.vue'
import TheFooter from './TheFooter.vue'
</script> 