<template>
    <div class="col-sm-1">
        <span class="pull-left text-center">
            <form v-show="auth" method="POST" :action="'/'+model+'/'+id+'/upvote'">
                <input name="_token" :value="csrf" type="hidden"/>
                <button :dusk="'upvote-'+model[0]+id" class="glyphicon glyphicon-chevron-up" type="submit"></button>
            </form>
            <vote-display>
                {{ votes.total }}
            </vote-display>
            <form v-show="auth" method="POST" :action="'/'+model+'/'+id+'/downvote'">
                <input name="_token" :value="csrf" type="hidden"/>
                <button :dusk="'downvote-'+model[0]+id" class="glyphicon glyphicon-chevron-down" type="submit"></button>
            </form>
        </span>
    </div>
</template>

<script>
  import axios from 'axios'
  import VoteDisplay from './vote/VoteDisplayComponent'

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
      auth: Boolean,
      csrf: String,
    },
    mounted () {
      axios.get('/api/' + this.model + '/' + this.id + '/votes').then((response) => {
        this.votes = response.data
      })
    },
  }
</script>

<style scoped>

</style>