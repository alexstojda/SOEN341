<template>
    <div :id="model[0]+'-'+id+'-vote'" class="col-md-1">
        <span class="pull-left text-center">
            <button v-show="show_buttons" :dusk="'upvote-'+model[0]+id" @click="upvote"
                    class="glyphicon glyphicon-arrow-up btn-circle" type="submit"></button>
            <vote-display>
                {{ votes.total }}
            </vote-display>
            <button v-show="show_buttons" :dusk="'downvote-'+model[0]+id" @click="downvote"
                    class="glyphicon glyphicon-arrow-down btn-circle" type="submit"></button>
        </span>
    </div>
</template>

<script>
  import axios from 'axios'
  import VoteDisplay from './VoteDisplayComponent'

  export default {
    name: 'vote',
    components: {VoteDisplay},
    data () {
      return {
        votes: {},
      }
    },
    props: {
      id: Number,
      model: String,
      show_buttons: [Boolean, false]
    },
    methods: {
      upvote () {
        axios.post('/api/' + this.model + '/' + this.id + '/upvote', {api_token: sessionStorage.getItem('token')}).then((response) => {
          this.votes = response.data
        })
      },
      downvote () {
        axios.post('/api/' + this.model + '/' + this.id + '/downvote', {api_token: sessionStorage.getItem('token')}).then((response) => {
          this.votes = response.data
        })
      }
    },
    created () {
      axios.get('/api/' + this.model + '/' + this.id + '/votes').then((response) => {
        this.votes = response.data
      })
    }
  }
</script>

<style scoped>

</style>