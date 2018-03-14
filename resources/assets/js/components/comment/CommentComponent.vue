<template>
    <li :id="'comment-'+comment.id" class="comment card list-group-item">
        <!--div class="comment-actions">
            <div class="comment-score">
                <span title="number of 'useful comment' votes received" class="warm">12</span>
            </div>
        </div-->
        <div class="comment-text card-body js-comment-text-and-form">
            <div style="display: block;" class="comment-body">
                <span class="comment-copy">
                    {{ comment.body }}
                </span>
                –&nbsp;<a>{{comment.author.name}}</a>
                <span class="comment-date " dir="ltr">
                    <a class="comment-link" :href="'#comment-'+comment.id">
                        <small :title="comment.date.full" class="relativetime-clean">{{comment.date.readable}}</small>
                    </a>
                </span>
            </div>
        </div>
    </li>
</template>

<script>
  export default {
    name: 'comment',
    props: {
      comment: {}
    }
  }
</script>

<style scoped>

</style>