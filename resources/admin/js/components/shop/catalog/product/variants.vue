<template>
    <ul id="example-1">
        <li v-for="variant in variants">
            {{ variant.message }}
        </li>
    </ul>
</template>

<script>
    console.log('variants init');

    export default {
        data() {
            return {
                variants: [
                    {message: 'Foo'},
                    {message: 'Bar'}
                ]
            }
        }
    }
</script>