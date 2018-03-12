<template>
    <button class="accept-answer btn glyphicon glyphicon-unchecked" @click="onClick"></button>
</template>

<script>
  export default {
    name: 'select-answer',
    data () {
      return {
        enabled: true,
        status: this.selected
      }
    },
    props: {
      id: Number,
      selected: [Boolean, false]
    },
    methods: {
      onClick (evt) {
        evt.preventDefault()
        //TODO learn proper vue prop enable/disable and dynamic classes attribution
        axios.get('/api/answers/' + this.id + '/accept?api_token=' + sessionStorage.getItem('token')).then((response) => {
          this.status = response.data.data.selected
          if (this.status === true) {
            $('.accept-answer').toggleClass('glyphicon-unchecked glyphicon-check btn-success')
          }
        })
      }
    },
    mounted () {

    }
  }
</script>

<style scoped>

</style>