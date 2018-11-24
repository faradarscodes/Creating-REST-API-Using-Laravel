<template>
    <li class="nav-item dropdown" v-show="notifications.length">
        <a href="#" id="navbarDropdown" class="nav-link dropdown-toggle" role="button" aria-haspopup="true"
           aria-expanded="false" data-toggle="dropdown">
            Notifications
        </a>


        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <span v-for="notification in notifications">
                    <a class="dropdown-item" :href="notification.data.link" v-text="notification.data
                .message" @click="markAsRead(notification)"></a>
                    </span>
        </div>

    </li>
</template>

<script>
    export default {
        name: "UserNotifications",
        props: ['user'],
        data() {
            return {
                user: '',
                notifications: false,
            }
        },

        created() {
            axios.get('/profiles/' + this.user + '/notifications')
                .then(response => this.notifications = response.data);
        },

        methods: {
            markAsRead(notification) {
                axios.delete('/profiles/' + this.user + '/notifications/' + notification.id);
            }
        }

    }
</script>

<style scoped>

</style>