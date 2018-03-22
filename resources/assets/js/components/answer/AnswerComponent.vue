// template for a single answer
<template>
    <div class="answer" :id="'a-'+answer.id">
        <div class="pull-left col-md-1 text-center">
            <vote :id="answer.id" model="answers" :show_buttons="show_forms"></vote>

            <button v-show="(this.answerSelected || this.qOwner)" class="accept-answer btn glyphicon"
                    :class="{'btn-success glyphicon-check': answerSelected, 'glyphicon-unchecked': !answerSelected, 'disabled': !answerEnabled}"
                    @click="onClick"></button>
        </div>

        <div class="col-md-11">
            <h4 v-html="renderMD(answer.body)"></h4>
            <br>
            <small>by {{answer.author.name}}</small>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'answer',
    props: {
      answer: {},
      qOwner: [Boolean, false],
      qAnswered: [Boolean, false],
      show_forms: [Boolean, false]
    },
    computed: {
      answerSelected: function () {
        return (this.answer.selected)
      },
      answerEnabled: function () {
        return (this.qOwner && (this.answerSelected || (!this.answerSelected && !this.qAnswered)))
      }
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
      },
      onClick (evt) {
        evt.preventDefault()

        if (this.answerEnabled) {
          axios.get('/api/answers/' + this.answer.id + '/accept?api_token=' + sessionStorage.getItem('token')).then((response) => {
            //this.$emit('update', {answer: response.data.data})
            this.$parent.handleSelectUpdate(response.data.data)
          }).catch((error) => {
            console.log(error)
          })
        }
      }
    }
  }
</script>

<style scoped>

</style>