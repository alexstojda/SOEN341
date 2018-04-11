// template for notification when successfully running `composer fix`
<template>
    <div class="container">
        <div class="alert alert-success">
            <slot></slot>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'notification-toast'
  }
</script>

<style scoped>

</style>