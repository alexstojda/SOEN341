<template>
    <div class="comments-container">
        <ul class="comments-list list-group">
            <comment :comment="comment" v-for="comment in comments" :key="comment.id"></comment>
        </ul>
        <button v-show="show_form" class="btn btn-default pull-right" @click="form.show=!form.show">Comment</button>

        <form class="form" v-show="form.show" @submit="onSubmit">
            <div class="form-group form-row">
                <label :for="form.id">Your comment:</label>
                <input :id="form.id" type="text" class="form-control" placeholder="Say something?"
                       name="body" v-model="form.text" required>
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>

    </div>
</template>

<script>
  import Comment from './CommentComponent'

  export default {
    name: 'comments',
    components: {Comment},
    data () {
      return {
        comments: [],
        form: {
          id: this.model[0] + this.id + '-comment-body',
          text: '',
          show: false
        }
      }
    },
    props: {
      id: Number,
      model: String,
      show_form: [Boolean, false]
    },
    methods: {
      onSubmit (evt) {
        evt.preventDefault()

        axios.post('/api/' + this.model + '/' + this.id + '/comment', {
          api_token: sessionStorage.getItem('token'),
          body: this.form.text
        }).then((response) => {
          this.comments = response.data.data
        })
        this.form.text = ''
        this.form.show = false
      },
      updateComments () {
        axios.get('/api/' + this.model + '/' + this.id + '/comments').then((response) => {
          this.comments = response.data.data
        })
      }
    },
    mounted () {
      this.updateComments()
    }
  }
</script>

<style scoped>

</style>