<template>
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li v-for="path in fullPath" :class="path.isActive ? 'is-active' : ''">
                <router-link :to="{ path: path.url }">{{ path.name }}</router-link>
            </li>
        </ul>
    </nav>
</template>

<script>
    import router from './../router'

    export default {
        data() {
            return {
                expandOnHover: false,
                mobile: "reduce",
                reduce: false,
                fullPath: getPaths(router.currentRoute.fullPath)
            };
        }
    };

    function getPaths(fullPath) {
        fullPath = fullPath.replace(/_/g, " ");

        let rawPaths = fullPath.split("/");
        let paths = [];
        let url = '';

        for (let index = 0; index < rawPaths.length; index++) {
            if (rawPaths[index] !== "") {
                paths.push({
                    name: rawPaths[index],
                    isActive: index === rawPaths.length - 1,
                    url: url += '/' + rawPaths[index],
                })
            }
        }

        if (paths.length === 0) {
            paths.push({
                name: router.currentRoute.name,
                isActive: true,
                url: '/',
            })
        }

        return paths;
    }
</script>
