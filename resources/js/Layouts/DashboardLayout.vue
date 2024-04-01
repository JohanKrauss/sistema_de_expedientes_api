<script setup>
import { ref, reactive } from 'vue';
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js';

const leftDrawerOpen = ref(false);
const link = ref('inicio');

const state = reactive({
    loading: false,
});

const toggleLeftDrawer = () => {
    leftDrawerOpen.value = !leftDrawerOpen.value;
};

const goRoute = (routeName) => {
    router.visit(route(routeName));
};
</script>

<template>
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
        </q-header>

        <q-drawer v-model="leftDrawerOpen" side="left">
            <q-list bordered padding>
                <q-item clickable v-ripple :active="link === 'inicio'" active-class="my-menu-link" tag="a" @click="goRoute('dashboard')">
                    <q-item-section>
                        <q-item-label>Inicio</q-item-label>
                    </q-item-section>
                </q-item>
                <q-item clickable v-ripple :active="link === 'tabla'" active-class="my-menu-link" tag="a" @click="goRoute('user.index')">  
                    <q-item-section>
                        <q-item-label>Lista de usuarios</q-item-label>
                    </q-item-section>
                </q-item>
                <q-item clickable v-ripple :active="link === 'create'" active-class="my-menu-link" tag="a" @click="goRoute('user.create')">
                    <q-item-section>
                        <q-item-label>Crear usuario</q-item-label>
                    </q-item-section>
                </q-item>

            </q-list>
        </q-drawer>

        <q-page-container class="full-height full-width q-pa-md">
            <div class="main">
                <slot />
            </div>
        </q-page-container>

    </q-layout>
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
