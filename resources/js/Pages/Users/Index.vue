<script>
export default {
    data() {
        return {
            users: [],
            loading: false
        };
    },
    mounted() {
        this.fetchUsers();
    },
    methods: {
        async fetchUsers() {
            try {
                this.loading = true;
                const response = await fetch('/users');
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();
                console.log(data);
                this.users = data.users;
            } catch (error) {
                console.error('Error fetching users:', error);
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>

<template>
    <div>
        <h2>Lista de Usuarios</h2>
        <ul v-if="!loading">
            <li v-for="user in users" :key="user.id">
                {{ user.name }} - {{ user.email }}
            </li>

        </ul>
        <p v-else>Cargando...</p>
    </div>
</template>