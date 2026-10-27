<script setup>
import {ref} from 'vue';
import axios from 'axios';
import {PhotoIcon, UserCircleIcon} from '@heroicons/vue/24/solid'
import {ChevronDownIcon} from '@heroicons/vue/16/solid'
import {toast} from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import AppLayout from "../Layouts/AppLayout.vue";

const props = defineProps({
    task: Object,
    projects: Array
});

const statuses = ['open', 'in-progress', 'completed'];

const taskId = props.task.task_id;

const taskFormData = ref({
    task_id: taskId,
    name: props.task.name,
    project: props.task.project_id,
    priority: props.task.priority,
    status: props.task.status

});

async function handleSubmit(event) {
    await axios.post(`/api/task/edit/${taskId}`, taskFormData.value)
        .then((response) => {
            const editStatus = response?.data.status ?? 'error';
            const message = response?.data.message ?? 'Unable to edit the task';

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
                        <h2 class="text-base/7 font-semibold text-white">Task</h2>

                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="taskName" class="block text-sm/6 font-medium text-white">Task Name</label>
                                <div class="mt-2">
                                    <div
                                        class="flex items-center rounded-md bg-white/5 pl-3 outline-1 -outline-offset-1 outline-white/10 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-500">
                                        <input type="text" name="taskName" id="taskName"
                                               class="block min-w-0 grow bg-transparent py-1.5 pr-3 pl-1 text-base text-white placeholder:text-gray-500 focus:outline-none sm:text-sm/6"
                                               placeholder="task name"
                                               v-model="taskFormData.name"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="project" class="block text-sm/6 font-medium text-white">Project</label>
                                <div class="mt-2 grid grid-cols-1">
                                    <select id="project" name="project"
                                            class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white/5 py-1.5 pr-8 pl-3 text-base text-white outline-1 -outline-offset-1 outline-white/10 *:bg-gray-800 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6"
                                            v-model="taskFormData.project"
                                    >
                                        <option v-for="project in projects" :key="project.project_id"
                                                :value="project.project_id"
                                                :selected="task.project_id === project.project_id"
                                        >
                                            {{ project.project_name }}
                                        </option>
                                    </select>
                                    <ChevronDownIcon
                                        class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-400 sm:size-4"
                                        aria-hidden="true"/>
                                </div>
                            </div>

                            <div class="sm:col-span-4">
                                <label for="priority" class="block text-sm/6 font-medium text-white">Priority</label>
                                <div class="mt-2">
                                    <div
                                        class="flex items-center rounded-md bg-white/5 pl-3 outline-1 -outline-offset-1 outline-white/10 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-500">
                                        <input type="text" name="priority" id="priority"
                                               class="block min-w-0 grow bg-transparent py-1.5 pr-3 pl-1 text-base text-white placeholder:text-gray-500 focus:outline-none sm:text-sm/6 cursor-not-allowed"
                                               v-model="taskFormData.priority"
                                               disabled
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="status" class="block text-sm/6 font-medium text-white">Status</label>
                                <div class="mt-2 grid grid-cols-1">
                                    <select id="status" name="status" autocomplete="project-name"
                                            class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white/5 py-1.5 pr-8 pl-3 text-base text-white outline-1 -outline-offset-1 outline-white/10 *:bg-gray-800 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6"
                                            v-model="taskFormData.status"
                                    >
                                        <option v-for="status in statuses" :key="status"
                                                :value="status" :selected="task.status === status">
                                            {{ status }}
                                        </option>
                                    </select>
                                    <ChevronDownIcon
                                        class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-400 sm:size-4"
                                        aria-hidden="true"/>
                                </div>
                            </div>
                        </div>
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
