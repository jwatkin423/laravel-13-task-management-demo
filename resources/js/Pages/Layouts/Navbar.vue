<script setup>
import {Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue'
import {Bars3Icon, XMarkIcon} from '@heroicons/vue/24/outline'
import {Link} from "@inertiajs/vue3";
import logo from "../../../images/tm-demo-logo/demo-call-tasks-icon.svg";

const activeLink = 'inline-flex items-center border-b-2 border-indigo-500 px-1 pt-1 text-sm font-medium text-white';

const inactiveLink = 'inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-300 hover:border-white/20 hover:text-white';

</script>


<template>
    <Disclosure as="nav"
                class="relative bg-gray-800/50 after:pointer-events-none after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-white/10"
                v-slot="{ open }">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 justify-between">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button -->
                    <DisclosureButton
                        class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-white/5 hover:text-white focus:ring-2 focus:ring-white focus:outline-hidden focus:ring-inset">
                        <span class="absolute -inset-0.5"></span>
                        <span class="sr-only">Open main menu</span>
                        <Bars3Icon v-if="!open" class="block size-6" aria-hidden="true"/>
                        <XMarkIcon v-else class="block size-6" aria-hidden="true"/>
                    </DisclosureButton>
                </div>
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex shrink-0 items-center">
                        <img class="h-8 w-auto"
                             :src="logo"
                             alt="Task Manager"/>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <Link href="/"
                              :class="($page.component === 'Tasks/Index' || $page.component === 'Tasks/View') ? activeLink : inactiveLink"
                        >
                            Tasks
                        </Link>
                        <Link href="/projects"
                              :class="($page.component === 'Projects/Index' || $page.component === 'Projects/View') ? activeLink : inactiveLink"
                        >
                            Projects
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </Disclosure>
</template>

<style scoped>

</style>
