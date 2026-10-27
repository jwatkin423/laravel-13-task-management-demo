<script setup>
import {ref} from 'vue';
import axios from 'axios';
import {toast} from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import AppLayout from "../Layouts/AppLayout.vue";
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    project: Object
});

const projectId = props.project.project_id;

const projectFormData = ref({
    project_id: projectId,
    project_name: props.project.project_name,
    project_description: props.project.project_description,
});

async function handleSubmit(event) {
    await axios.post(`/api/project/edit/${projectId}`, projectFormData.value)
        .then((response) => {
            const editStatus = response?.data.status ?? 'error';
            const message = response?.data.message ?? 'Unable to edit the project';

            // display the toast message
            toast(message, {
                'theme': 'auto',
                'type': editStatus,
                'dangerouslyHTMLString': true,
            });
        });
}

</script>

<template>
    <app-layout>
        <div class="flex justify-center items-center w-full">
            <form class="bg-gray-800/50 outline -outline-offset-1 outline-white/10 sm:rounded-xl md:col-span-2 p-4" @submit.prevent="handleSubmit($event)">
                <div class="space-y-12">
                    <div class="border-b border-white/10 pb-12">
                        <h2 class="text-base/7 font-semibold text-white">Project</h2>

                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="projectName" class="block text-sm/6 font-medium text-white">Project Name</label>
                                <div class="mt-2">
                                    <div
                                        class="flex items-center rounded-md bg-white/5 pl-3 outline-1 -outline-offset-1 outline-white/10 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-500">
                                        <input type="text" name="projectName" id="projectName"
                                               class="block min-w-0 grow bg-transparent py-1.5 pr-3 pl-1 text-base text-white placeholder:text-gray-500 focus:outline-none sm:text-sm/6"
                                               placeholder="project name"
                                               v-model="projectFormData.project_name"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-4">
                                <label for="projectName" class="block text-sm/6 font-medium text-white">Project Name</label>
                                <div class="mt-2">
                                    <div
                                        class="flex items-center rounded-md bg-white/5 pl-3 outline-1 -outline-offset-1 outline-white/10 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-500">
                                        <input type="text" name="projectName" id="projectName"
                                               class="block min-w-0 grow bg-transparent py-1.5 pr-3 pl-1 text-base text-white placeholder:text-gray-500 focus:outline-none sm:text-sm/6"
                                               placeholder="project description"
                                               v-model="projectFormData.project_description"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="space-y-12">
                    <div class="border-b border-white/10 pb-12">
                        <h2 class="text-base/7 font-semibold text-white">Tasks for this project:</h2>
                        <ul class="list-inside">
                            <li
                                v-for="task in project.tasks"
                                :key="task.task_id"
                                class="text-gray-400"
                            >
                                <Link :href="`/view/${task.task_id}`"
                                      class="block w-full border-b border-gray-600 px-4 py-2 hover:bg-gray-600 hover:text-blue-300 transition duration-150"
                                >
                                    {{ task.task_id }} - {{ task.name }}
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button type="submit"
                            class="rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </app-layout>
</template>
