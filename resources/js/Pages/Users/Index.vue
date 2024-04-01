<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import { onMounted, reactive } from 'vue';

const state = reactive({
    users: [],
});

const fetchUsers = async () => {
  try {
    state.loading = true; // Cambiado de this.loading a state.loading
    const response = await fetch('/users');
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    const data = await response.json();
    state.users = data.users;
  } catch (error) {
    console.error('Error fetching users:', error);
  } finally {
    state.loading = false; // Cambiado de this.loading a state.loading
  }
};

onMounted(async () => {
  await fetchUsers();
})

</script>

<template>
  <DashboardLayout>

    <q-page-container class="full-height full-width q-pa-md">
      <div class="main">
        <q-table title="Usuarios" :rows="state.users" :columns="[
          { name: 'name', label: 'Nombre', align: 'left', field: row => row.name },
          { name: 'email', label: 'Correo', align: 'left', field: row => row.email }
        ]" row-key="id" />
      </div>
    </q-page-container>

  </DashboardLayout>
</template>

<style lang="sass">
.main
  margin-top: 20px
.my-menu-link
  color: white
  background: #F2C037
.my-card
  width: 100%
  max-width: 250px
</style>
