<template>
<div>
    <nav-bar />
    <router-view></router-view>
</div>
</template>

<script>
import NavBar from "../layout/NavBar";
export default {
    components: {
        NavBar
    }
};
</script>

<style></style>
