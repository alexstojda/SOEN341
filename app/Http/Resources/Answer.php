<?php

    namespace App\Http\Resources;

    use Illuminate\Http\Resources\Json\JsonResource;

    class Answer extends JsonResource {
        /**
         * Transform the resource into an array.
         *
         * @param  \Illuminate\Http\Request $request
         *
         * @return array
         */
        public function toArray($request) {
            return [
                'id'   => $this->id,
                'body' => $this->body,
                'selected' => ($this->id === $this->parent->answer_id),

                'date' => [
                    'full'     => $this->updated_at->format('Y-m-d T H:i:s'),
                    'readable' => $this->updated_at->diffForHumans(),
                ],

                'author' => [
                    'id'   => $this->author_id,
                    'name' => $this->user->name,
                    'more' => url("api/users/$this->author_id"),
                ],

                'parent'   => ['id' => $this->question_id, 'more' => url("api/questions/$this->question_id")],
                'comments' => ['count' => \count($this->comments), 'more' => url("api/answers/$this->id/comments")],
                'votes'    => ['total' => $this->countTotalVotes(), 'more' => url("api/answers/$this->id/votes")],
            ];
        }
    }
