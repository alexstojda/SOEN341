<template>
    <div>
        <span> {{ votes.total }}</span>
        </br>
    </div>
</template>

<script>
  import axios from 'axios'

  export default {
    name: 'vote',
    data () {
      return {votes: {}}
    },
    props: {
      model: String,
      id: String,
    },
    mounted () {
      axios.get('/api/' + this.model + '/' + this.id + '/votes').then((response) => {
        this.votes = response.data;
      })
    },
  }
</script>

<style scoped>

</style>