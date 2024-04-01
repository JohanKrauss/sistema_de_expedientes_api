<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import { ref } from 'vue';
import { route } from 'ziggy-js';

const alert = ref(false);
const textAlert = ref('');
const colorAlert = ref('bg-primary');
const formData = ref({
  name: '',
});

const submitForm = async () => {
  try {
    alert.value = true;
      textAlert.value = 'Cargando';
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const response = await fetch(route('user.store'), {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken, // Incluye el token CSRF en los headers
      },
      body: JSON.stringify(formData.value),
    });
    const data = await response.json();
    if (response.status !== 200)
        throw new Error(data.message);

    colorAlert.value = 'bg-positive';
    textAlert.value = 'Usuario creado correctamente';
  } catch (error) {
    colorAlert.value = 'bg-warning';
    //console.error('Error al enviar el formulario:', error);
    textAlert.value = 'Error al enviar el formulario ' + error;
  }
};

</script>

<template>
  <DashboardLayout>

    <q-page-container class="full-height full-width q-pa-md">
      <div class="main">

        <q-form @submit="submitForm" class="q-gutter-md">
          <q-input filled v-model="formData.name" label="Nombre" hint="Nombre del usuario" lazy-rules
            :rules="[val => val && val.length > 0 || 'Por favor escribe algo']" />

          <div>
            <q-btn label="Crear" type="submit" color="primary" />
            <q-btn label="Limpiar" type="button" color="primary" flat class="q-ml-sm" />
          </div>
        </q-form>
      </div>
    </q-page-container>

  </DashboardLayout>

    <q-dialog v-model="alert">
        <q-card>
            <q-card-section :class="colorAlert">
                <div class="text-h6">Alerta!</div>
            </q-card-section>

            <q-card-section class="q-pt-none">
                <div class="text-h6">{{textAlert}}</div>
            </q-card-section>
        </q-card>
    </q-dialog>
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
