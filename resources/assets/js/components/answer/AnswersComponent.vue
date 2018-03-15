<template>
    <div id="answers-container" class="container-fluid">
        <h3>{{count}} Answers</h3>
        <hr>
        <div class="row">
            <div class="col-md-12 answers" v-for="answer in answers" :key="answer.id" v-if="loaded"
                 :id="'q-' + qid + '-answers'">
                <answer class="row" :answer="answer" :show_forms="form.show"
                        :qAnswered="qAnswered" :qOwner="(uid === answer.parent.author_id)"></answer>

                <div class="row" :id="'a-'+answer.id+'-comments'">
                    <comments class="col-md-11 col-md-offset-1" model="answers" :id="answer.id"
                              :show_form="show_forms"></comments>
                </div>
            </div>

            <div v-show="form.show" class="row answers-form container">
                <form class="form" @submit="onSubmit">
                    <div class="form-group">
                        <label :for="form.id">Your answer:</label>
                        <markdown-editor preview-class="markdown-body" v-model="form.text" :ref="form.id" name="body"
                                         required></markdown-editor>
                    </div>
                    <button type="submit" class="btn btn-primary">Answer</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
  import Answer from './AnswerComponent'
  import Comments from '../comment/CommentsComponent'
  import markdownEditor from 'vue-simplemde/src/markdown-editor'

  export default {
    name: 'answers',
    components: {Answer, markdownEditor, Comments},
    data () {
      return {
        loaded: false,
        answers: [],
        count: null,
        form: {
          id: 'q' + this.qid + '-answer-body',
          text: '',
          show: this.show_forms
        }
      }
    },
    props: {
      qid: Number,
      uid: [Number, null],
      show_forms: [Boolean, false]
    },
    computed: {
      qAnswered: function () {
        return (_.find(this.answers, ['selected', true]) !== undefined)
      }
    },
    methods: {
      handleSelectUpdate (answer) {  // 2 hacky methods for the price of 1
        let answers = this.answers.slice() //_.cloneDeep(this.answers) // force clone array so we can replace it later
        let i = _.findIndex(answers, ['id', answer.id])
        answers[i] = answer // is we do this on original then it never re-computes qAnswered
        this.answers = answers // using cloned array to trigger re-compute and whole list wide 'qAnswered' prop update
      },
      onSubmit (evt) {
        evt.preventDefault()

        axios.post('/api/questions/' + this.qid + '/answer', {
          api_token: sessionStorage.getItem('token'),
          body: this.form.text
        }).then((response) => {
          this.answers = response.data.data
        })
        this.form.text = ''
        this.form.show = false
      },
      update () {
        this.loaded = false
        axios.get('/api/questions/' + this.qid + '/answers').then((response) => {
          this.answers = response.data.data
          this.count = this.answers.length //Object.keys(this.answers).length\
          this.loaded = true
        })
      }
    },
    created () {
      this.update()
    }
  }
</script>

<style scoped>
    @import '~simplemde/dist/simplemde.min.css';
    @import url(https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/2.10.0/github-markdown.css);

    .editor-toolbar.fullscreen {
        z-index: 1100 !important;
    }
</style>