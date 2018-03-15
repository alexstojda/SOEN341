<template>
    <ul>
        <li v-for="question in questions" :key="question.id">

            <a :href="'/questions/'+question.id"> {{ question.title }}</a> <small>by {{question.author.name}} </small>

        </li>
    </ul>
</template>

<script>
    export default {
        name: "questions-top",
        data() {
            return {
                questions: []
            }
        },
        mounted() {
            axios.get('/api/questions/top').then((response) => {
                this.questions = response.data.data
            })
        }
    }
</script>

<style scoped>

</style>