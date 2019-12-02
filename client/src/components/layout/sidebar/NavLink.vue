<template>
<li class="treeview" :class="{active:bool}">
    <!-- menu -->
    <a class="app-menu__item" :class="{active:bool}" data-toggle="treeview" @click="show()">
        <i class="app-menu__icon fa fa-laptop"></i>
        <span class="app-menu__label">{{title}}</span>
        <i class="treeview-indicator fa fa-angle-right" :class="{rotate: bool}"></i>
    </a>
    <!-- item -->
    <ul class="treeview-menu">
        <!-- option slot -->
        <slot></slot>
    </ul>
</li>
</template>

<script>
export default {
    data() {
        return {
            bool: false
        };
    },
    props: {
        title: {
            type: String,
            default: "default"
        }
    },
    methods: {
        show() {
            this.bool = !this.bool;
        }
    }
};
</script>

<style lang="less">
.rotate {
    -webkit-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    transform: rotate(90deg);
}
</style>
