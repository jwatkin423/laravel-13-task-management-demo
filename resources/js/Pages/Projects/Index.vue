<script setup>
import AppLayout from "../Layouts/AppLayout.vue";
import {TrashIcon, PencilIcon} from "@heroicons/vue/24/solid";
import {ref} from "vue";
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    projects: Array
})

const projectHeaderColumns = [
    {'number': 1, 'name': 'Id'},
    {'number': 2, 'name': 'Name'},
    {'number': 3, 'name': 'Description'},
    {'number': 4, 'name': 'Edit'},
];

// this is set to a non-proxy array
const projectList = ref(props.projects);

</script>

<template>
    <AppLayout>
        <div class="p-4">
            <table class="text-left table-auto w-full bg-gray-700">
                <thead class="mb-4">
                <tr>
                    <th v-for="projectHeaderColumn in projectHeaderColumns" :key="projectHeaderColumn.number"
                        class="p-4 border-b border-blue-gray-100 bg-blue-gray-50 text-lg"
                    >
                        <p class="block font-sans text-sm antialiased font-normal leading-none text-white">
                            {{ projectHeaderColumn.name }}
                        </p>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="project in projectList"
                    :key="project.project_id"
                >
                    <td class="p-4 border-b border-blue-gray-50">
                        <p class="block font-sans text-sm antialiased font-normal leading-normal text-gray-200">
                            {{ project.project_id }}
                        </p>
                    </td>
                    <td class="p-4 border-b border-blue-gray-50">
                        <p class="block font-sans text-sm antialiased font-normal leading-normal text-gray-200">
                            {{ project.project_name }}
                        </p>
                    </td>
                    <td class="p-4 border-b border-blue-gray-50">
                        <p class="block font-sans text-sm antialiased font-normal leading-normal text-gray-200">
                            {{ project.project_description }}
                        </p>
                    </td>
                    <td class="p-4 border-b border-blue-gray-50">
                        <Link :href="`/projects/view/${project.project_id}`"
                              class="block font-sans text-sm antialiased font-medium leading-normal text-gray-200">
                            <PencilIcon class="size-5 text-gray-300"/>
                        </Link>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
