<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import { ref } from 'vue';
import { route } from 'ziggy-js';

const formData = ref({
  email: '',
});

const submitForm = async () => {
  try {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const response = await fetch(route('user.store'), {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken, // Incluye el token CSRF en los headers
      },
      body: JSON.stringify(formData.value),
    });
    if (!response.ok) {
      throw new Error('Hubo un error al enviar el formulario.');
    }
    // Manejar la respuesta si es necesario
  } catch (error) {
    console.error('Error al enviar el formulario:', error);
  }
};

</script>

<template>
  <DashboardLayout>

    <q-page-container class="full-height full-width q-pa-md">
      <div class="main">

        <q-form @submit="submitForm" @reset="onReset" class="q-gutter-md">
          <q-input filled v-model="formData.email" label="Email" hint="Correo requerido" lazy-rules
            :rules="[val => val && val.length > 0 || 'Por favor escribe algo']" />
         
          <div>
            <q-btn label="Crear" type="submit" color="primary" />
            <q-btn label="Limpiar" type="reset" color="primary" flat class="q-ml-sm" />
          </div>
        </q-form>
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
