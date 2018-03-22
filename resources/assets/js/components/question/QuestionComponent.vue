// template for single question
<template>
    <div id="question-container" v-if="loaded" class="container-fluid">
        <div class="row" :id="'q-'+question.id">
            <h2> {{question.title}} </h2>
            <hr>
            <div class="col-md-1">
                <span class="pull-left text-center">
                    <vote :id="id" model="questions" :show_buttons="show_forms"></vote>
                </span>
            </div>
            <div class="col-md-11" v-html="renderMD(question.body)"></div>
        </div>
        <div class="row">
            <div class="pull-right text-center">
               <a> By {{ question.author.name }} </a><br>
                {{ question.dates.created.readable }}
            </div>
            <br>
            <hr>

            <comments model="questions" class="col-md-11 col-md-offset-1" :id="id"
                      :show_form="show_forms"></comments>
        </div>
    </div>
</template>

<script>
  import Comments from '../comment/CommentsComponent'

  export default {
    name: 'question',
    components: {Comments},
    data () {
      return {
        loaded: false,
        question: {}
      }
    },
    props: {
      id: Number,
      show_forms: [Boolean, false]
    },
    methods: {
      renderMD (md_text) {
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
      }
    },
    created () {
      axios.get('/api/questions/' + this.id).then((response) => {
        this.question = response.data.data
        this.loaded = true
      })
    }
  }
</script>

<style scoped>

</style>