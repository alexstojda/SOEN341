<template>
    <div class="container-fluid">
        <h3>{{count}} Answers</h3>
        <hr>
        <div class="container answers-list">
            <div class="row answer" :id="'answer-'+answer.id" v-for="answer in answers" :key="answer.id">
                <div class="pull-left col-md-1 text-center">
                    <vote :id="answer.id" model="answers" :show_buttons="show_forms"></vote>

                    <select-answer v-show="uid === answer.author.id" :id="answer.id" :selected="answer.selected"></select-answer>
                </div>


                <h4 v-html="renderMD(answer.body)">
                </h4>
                <br>
                <small>by {{answer.author.name}}</small>

                <comments class="col-md-11 col-md-offset-1" model="answers" :id="answer.id"
                          :show_form="show_forms"></comments>
            </div>
        </div>

        <div v-show="form.show" class="container answers-form">
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
</template>

<script>
  import Comments from '../comment/CommentsComponent'
  import SelectAnswer from './SelectAnswerComponent'
  import markdownEditor from 'vue-simplemde/src/markdown-editor'

  export default {
    name: 'answers',
    components: {SelectAnswer, markdownEditor, Comments},
    data () {
      return {
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
    methods: {
      renderMD (md_text) { //TODO:@Stojda verify I haven't broken the page with these render options
        marked.setOptions({
          renderer: new marked.Renderer(),
          gfm: true,
          tables: true,
          breaks: true,
          pedantic: false,
          sanitize: true,
          smartLists: true,
          smartypants: false
        })
        return marked(md_text)
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
        axios.get('/api/questions/' + this.qid + '/answers').then((response) => {
          this.answers = response.data.data
          this.count = this.answers.length //Object.keys(this.answers).length
        })
      }
    },
    mounted () {
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