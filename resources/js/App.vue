<template>
    <div
        class="flex flex-col h-screen bg-gradient-to-r from-blue-400 to-purple-600"
    >
        <!-- Navbar -->
        <nav class="bg-white bg-opacity-80 shadow-md p-4">
            <div class="container mx-auto flex justify-start items-center">
                <h1 class="text-2xl font-bold text-blue-800">My Vue App</h1>
                <div class="ml-4">
                    <router-link
                        to="/"
                        class="text-blue-800 mx-4 hover:text-blue-600"
                        >Home</router-link
                    >
                    <router-link
                        to="/about"
                        class="text-blue-800 mx-4 hover:text-blue-600"
                        >About</router-link
                    >
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main
            class="flex-grow flex items-center justify-center text-center text-white"
        >
            <router-view />
        </main>

        <!-- Footer -->
        <footer class="bg-white bg-opacity-80 py-4 text-center shadow-md">
            <p class="text-gray-600">
                &copy; 2024 My Vue App. All rights reserved.
            </p>
        </footer>
    </div>
</template>

<script lang="ts">
export default {
    name: "App",
};
</script>

<style>
/* Additional global styles can go here */
</style>
