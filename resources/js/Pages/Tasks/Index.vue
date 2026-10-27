<script setup>
import AppLayout from "../Layouts/AppLayout.vue";
import DeleteTaskModal from "../../components/Modals/DeleteTaskModal.vue";
import {TrashIcon, PencilIcon} from "@heroicons/vue/24/solid";
import { ref, computed } from "vue";
import {useDraggable} from "vue-draggable-plus";
import axios from "axios";
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import {Link} from "@inertiajs/vue3";
import {ChevronDownIcon} from "@heroicons/vue/16/solid";

// props for the component
const props = defineProps({
    tasks: Array,
    projects: Array
})

// column header names
const taskHeaderColumns = [
    {'number': 1, 'name': 'Id'},
    {'number': 2, 'name': 'Name'},
    {'number': 3, 'name': 'Project Name'},
    {'number': 4, 'name': 'Priority'},
    {'number': 5, 'name': 'Status'},
    {'number': 6, 'name': 'Edit'},
    {'number': 7, 'name': 'Delete'}
];

// get the project name from the project Id
const getProjectName = (project_id) => {
    const project = props.projects.find(project => project.project_id === project_id)
    return project?.project_name
};

// this is set to a non-proxy array
const taskList = ref(props.tasks);
// for drag and drop
const tableBody = ref(null);
// the task object for the moda
const modalTask = ref();
// toggle to show/hide modal
const openModal = ref(false);

// reorders the priority
// based on the index of the task in the list
async function reorderPriorityId(tasks) {
    const reorderedTasks = tasks.value.map(task => ({...task}));

    await axios.post('api/task/reorder', {tasks: reorderedTasks})
        .then((response) => {
            // get the response type
            const reorderStatus = response?.data.status ?? 'error';
            // get the message type
            const message = response?.data.message ?? 'Unable to process request, try again';

            // display the toast message
            toast(message, {
                'theme': 'auto',
                'type': reorderStatus,
                'dangerouslyHTMLString': true
            })
        });
}

// drag and drop rows
useDraggable(tableBody, taskList, {
    animation: 200,
    onEnd: async () => {
        await reorderPriorityId(taskList)
    }
})

const projectFilter = ref('All');

const filteredTasks = computed(() => {
    console.log(projectFilter.value);
    if (projectFilter.value === 'All') {
        return taskList.value;
    }

    return taskList.value.filter(task => {
        return task.project_id === projectFilter.value;
    });
});

// clears the project filter
const clearFilter = () => {
    projectFilter.value = 'All';
}

// opens the modals
const openDeleteModal = (taskToBeDeleted) => {
    modalTask.value = taskToBeDeleted;
    openModal.value = true;
};

// when handles the emit to close the modal
// if the id is 0 just close the modal
const closeModal = (id) => {
    if (id) {
        deleteTask(id)
    }
    openModal.value = false;
    // unset the task passed to the modal
    modalTask.value = null;
};

// deletes from the list without needing to reload
const removeTaskFromList = (id) => {
    taskList.value = taskList.value.filter(task => task.task_id !== id);
}

async function deleteTask (id) {
    await axios.delete(`api/task/delete/${id}`)
        .then(response => {
            // get the response type
            const deleteStatus = response?.data.status ?? 'error';
            // get the message type
            const message = response?.data.message ?? 'Unable to process request, try again';

            removeTaskFromList(id);

            toast(message, {
                    'theme': 'auto',
                    'type': deleteStatus,
                    'dangerouslyHTMLString': true
                }
            );
        });
}

</script>

<template>
    <AppLayout>
        <div class="p-4">
            <div class="flex justify-end mb-3">
                <div class="flex items-center gap-3">
                    <label for="status" class="text-sm font-medium text-gray-400 whitespace-nowrap">
                        Project filter:
                    </label>
                    <div class="mt-2 grid grid-cols-1">
                        <select id="projectFilter" name="projectFilter"
                                class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white/5 py-1.5 pr-8 pl-3 text-base text-white outline-1 -outline-offset-1 outline-white/10 *:bg-gray-800 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6"
                                v-model="projectFilter"
                        >
                            <option value="All"></option>
                            <option v-for="project in projects" :key="project.project_id"
                                    :value="project.project_id"
                            >
                                {{ project.project_name }}
                            </option>
                        </select>
                        <ChevronDownIcon
                            class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-400 sm:size-4"
                            aria-hidden="true"/>
                    </div>
                    <button type="button"
                            class="rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"
                            @click="clearFilter"
                    >
                        clear
                    </button>
                </div>
            </div>
            <table class="text-left table-auto w-full bg-gray-700">
                <thead class="mb-4">
                <tr>
                    <th v-for="taskHeaderColumn in taskHeaderColumns" :key="taskHeaderColumn.number"
                        class="p-4 border-b border-blue-gray-100 bg-blue-gray-50 text-lg"
                    >
                        <p class="block font-sans text-sm antialiased font-normal leading-none text-white">
                            {{ taskHeaderColumn.name }}
                        </p>
                    </th>
                </tr>
                </thead>
                <tbody ref="tableBody">
                <tr v-for="task in filteredTasks"
                    :key="task.task_id"
                    class="cursor-move"
                >
                    <td class="p-4 border-b border-blue-gray-50">
                        <p class="block font-sans text-sm antialiased font-normal leading-normal text-gray-200">
                            {{ task.task_id }}
                        </p>
                    </td>
                    <td class="p-4 border-b border-blue-gray-50">
                        <p class="block font-sans text-sm antialiased font-normal leading-normal text-gray-200">
                            {{ task.name }}
                        </p>
                    </td>
                    <td class="p-4 border-b border-blue-gray-50">
                        <p class="block font-sans text-sm antialiased font-normal leading-normal text-gray-200">
                            {{ getProjectName(task.project_id) }}
                        </p>
                    </td>
                    <td class="p-4 border-b border-blue-gray-50">
                        <p class="block font-sans text-sm antialiased font-normal leading-normal text-gray-200">
                            {{ task.priority }}
                        </p>
                    </td>
                    <td class="p-4 border-b border-blue-gray-50">
                        <p class="block font-sans text-sm antialiased font-normal leading-normal text-gray-200">
                            {{ task.status }}
                        </p>
                    </td>
                    <td class="p-4 border-b border-blue-gray-50">
                        <Link :href="`/view/${task.task_id}`"
                           class="block font-sans text-sm antialiased font-medium leading-normal text-gray-200">
                            <PencilIcon class="size-5 text-gray-300"/>
                        </Link>
                    </td>
                    <td class="p-4 border-b border-blue-gray-50">
                        <button @click="openDeleteModal(task)">
                            <TrashIcon class="size-5 text-red-700"/>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <DeleteTaskModal  :is-open="openModal" :task="modalTask"  @modal-close="closeModal"/>
    </AppLayout>
</template>
