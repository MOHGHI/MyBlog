<?php


namespace App\Service;


class FormValidation
{
    public function formValidation(\App\Model $model = null, $id = null)
    {
        $request_arr = request()->validate([
            'title' => 'required|min:5|max:100',
            'short_body' => 'required|max:255',
            'body' => 'required',
        ]);

        if($id && $id->id == $model->id) {
            $slug = request()->validate([
                'slug' =>
                    array(
                        'required',
                        'regex:/(^([a-zA-Z0-9-_]+)(\d+)?$)/u'
                    ),
            ]);
        }else {
            $slug = request()->validate([
                'slug' =>
                    array(
                        'required',
                        'unique:news,slug',
                        'regex:/(^([a-zA-Z0-9-_]+)(\d+)?$)/u'
                    ),
            ]);
        }

        $request_arr['slug'] = $slug['slug'];
        $request_arr['published']  = request('published') == 'on' ? 1 : 0;
        $tags = collect(explode(',', \request('tags')))->keyBy(function ($item) {
            return $item;
        });

        return ['attributes' => $request_arr, 'tags' => $tags];
    }
}