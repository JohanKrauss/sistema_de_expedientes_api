<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout.vue';
import { ref, onMounted, reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { route } from 'ziggy-js';

const leftDrawerOpen = ref(false);
const link = ref('tabla');

const state = reactive({
    users: [],
    loading: false,
});

const toggleLeftDrawer = () => {
    leftDrawerOpen.value = !leftDrawerOpen.value;
};

const fetchUsers = async () => {
    try {
        state.loading = true; // Cambiado de `this.loading` a `state.loading`
        const response = await fetch('/users');
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        state.users = data.users;
    } catch (error) {
        console.error('Error fetching users:', error);
    } finally {
        state.loading = false; // Cambiado de `this.loading` a `state.loading`
    }
};

const goUserResource = (routeName) => {
    Inertia.visit(route(routeName));
};

onMounted(async () => {
    await fetchUsers();
})
</script>

<template>
  <Head title="Dashboard" />
  <AuthenticatedLayout>
    <q-layout view="hHh lpR fFf">

      <q-header elevated class="bg-primary text-white" height-hint="98">
        <q-toolbar>
          <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />

          <q-toolbar-title>
            <q-avatar>
              <img src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg">
            </q-avatar>
            Usuarios
          </q-toolbar-title>
        </q-toolbar>

        <!-- <q-tabs align="left">
                    <q-route-tab to="/page1" label="Todos los usuarios" />
                    <q-route-tab to="/page2" label="Agregar usuario" />
                </q-tabs> -->
      </q-header>

      <q-drawer v-model="leftDrawerOpen" side="left">
        <q-list bordered padding>
          <q-item clickable v-ripple :active="link === 'tabla'" @click="link = 'tabla'" active-class="my-menu-link">
            <q-item-section>
              <q-item-label>Lista de usuarios</q-item-label>
            </q-item-section>
          </q-item>
            <q-item clickable v-ripple :active="link === 'create'" active-class="my-menu-link" tag="a" @click="goUserResource('user.create')">
                <q-item-section>
                    <q-item-label>Crear usuario</q-item-label>
                </q-item-section>
            </q-item>

        </q-list>
      </q-drawer>

      <q-page-container class="full-height full-width q-pa-md">
        <div class="main">
          <q-table title="Usuarios" :rows="state.users" :columns="[
            { name: 'name', label: 'Nombre', align: 'left', field: row => row.name },
            { name: 'email', label: 'Correo', align: 'left', field: row => row.email }
          ]" row-key="id" />
        </div>
      </q-page-container>

    </q-layout>
  </AuthenticatedLayout>
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
