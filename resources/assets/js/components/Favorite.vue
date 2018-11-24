<template>
    <button type="submit" :class="classes" @click="toggle">
        Favorite
        <span v-text="favoritesCount"></span>
    </button>
</template>

<script>
    export default {
        props: ['reply'],
        data() {
            return {
                favoritesCount: this.reply.favoritesCount,
                isFavorited: this.reply.isFavorited,
                endPoint: '/replies/' + this.reply.id + '/favorites'
            }
        },
        methods: {
            toggle() {
                this.isFavorited ? this.destroy() : this.create();
            },
            create() {
                axios.post(this.endPoint);
                this.isFavorited = true;
                this.favoritesCount++;
            },
            destroy() {
                axios.delete(this.endPoint);
                this.isFavorited = false;
                this.favoritesCount--;
            }
        },
        computed: {
            classes() {
                return ['btn', this.isFavorited ? 'btn-primary' : 'btn-default']
            }
        }
    }
</script>

<style scoped>
button {
    float: right;
}
</style>