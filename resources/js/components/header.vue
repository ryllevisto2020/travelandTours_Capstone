<template>
    <h1>
        VUE HEADER
    </h1>

        <div>
            <router-link to="/">Home</router-link>
            <router-link to="/about">About</router-link>
        </div>
    
    <main>
        <router-view/>
    </main>
</template>