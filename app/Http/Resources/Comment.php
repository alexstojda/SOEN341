<?php

    namespace App\Http\Resources;

    use Illuminate\Http\Resources\Json\JsonResource;

    class Comment extends JsonResource {
        /**
         * Transform the resource into an array.
         *
         * @param  \Illuminate\Http\Request $request
         *
         * @return array
         */
        public function toArray($request) {
            $parent = \get_class($this->parent);
            $model = ($parent === 'App\Question' ? 'questions' : 'answers');

            return [
                'id'   => $this->id,
                'body' => $this->body,

                'date' => [
                    'full'     => $this->updated_at->format('Y-m-d T H:i:s'),
                    'readable' => $this->updated_at->diffForHumans(),
                ],

                'author' => [
                    'id'   => $this->author_id,
                    'name' => $this->user->name,
                    'more' => url("api/users/$this->author_id"),
                ],

                'parent' => [
                    'id'          => $this->parent->id,
                    'parent_type' => $parent,
                    'more'        => url('api/'.$model.'/'.$this->parent->id),
                ],
            ];
        }
    }
