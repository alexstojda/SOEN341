<?php

    namespace App\Http\Resources;

    use Illuminate\Http\Resources\Json\JsonResource;

    class Question extends JsonResource {
        /**
         * Transform the resource into an array.
         *
         * @param  \Illuminate\Http\Request $request
         *
         * @return array
         */
        public function toArray($request) {
            return [
                'id'     => $this->id,
                'title'  => $this->title,
                'body'   => $this->body,
                'status' => $this->status,

                'dates' => [
                    'created' => [
                        'full'     => $this->updated_at->format('Y-m-d T H:i:s'),
                        'readable' => $this->updated_at->diffForHumans(),
                    ],
                    'updated' => [
                        'full'     => $this->created_at->format('Y-m-d T H:i:s'),
                        'readable' => $this->created_at->diffForHumans(),
                    ],
                ],

                'author' => [
                    'id'   => $this->author_id,
                    'name' => $this->user->name,
                    'more' => url("api/users/$this->author_id"),
                ],

                'answers'  => [
                    'count'    => \count($this->answers),
                    'selected' => $this->accepted !== null ? [
                        'id'   => $this->answer_id,
                        'more' => url("api/answers/$this->answer_id"),
                    ] : null,
                    'more'     => url("api/questions/$this->id/answers"),
                ],
                'comments' => [
                    'count' => \count($this->comments),
                    'more'  => url("api/questions/$this->id/comments"),
                ],
                'votes'    => ['total' => $this->countTotalVotes(), 'more' => url("api/questions/$this->id/votes")],
            ];
        }
    }
