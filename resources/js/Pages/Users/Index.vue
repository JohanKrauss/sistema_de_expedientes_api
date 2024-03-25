<script setup lang="js">
import {ref, computed, nextTick, onMounted, reactive } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3';

const { props } = usePage();

const columns = [
    {
        name: 'id',
        label: 'ID',
        field: row => row.id
    },
    {
        name: 'name',
        label: 'Name',
        field: row => row.name,
        sortable: true
    },
]

const allRows = computed(() => users || [])
const lastPage = computed(() => Math.ceil(allRows.value.length / pageSize))

const pageSize = 50

const nextPage = ref(2)
const loading = ref(false)
const rows = computed(() => allRows.slice(0, pageSize * (nextPage.value - 1)))
const pagination = { rowsPerPage: 0 }

function onScroll ({ to, ref }) {
    const lastIndex = rows.value.length - 1

    if (loading.value !== true && nextPage.value < lastPage && to === lastIndex) {
        loading.value = true

        setTimeout(() => {
            nextPage.value++
            nextTick(() => {
                ref.refresh()
                loading.value = false
            })
        }, 500)
    }
}

onMounted(() => {
    console.log(props.value)
});
</script>
<template>
    <div>
        <table>
            <thead>
            <tr>
                <th v-for="column in columns" :key="column.name">
                    {{ column.label }}
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users" :key="user.id">
                <td v-for="column in columns" :key="column.name">
                    {{ typeof column.field === 'function' ? column.field(user) : user[column.field] }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
