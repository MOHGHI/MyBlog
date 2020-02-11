@php
    $post = $post ?? null;
@endphp

<div class="form-group">
    <label for="inputTitle">Символьный код</label>
    <input type="text" class="form-control" id="inputSlug" name="slug" placeholder="Введите Символьный код" value="{{old('slug', $post ? $post->slug : '')}}">
</div>
<div class="form-group">
    <label for="inputTitle">Название статьи </label>
    <input type="text" class="form-control" id="inputTitle" name="title" placeholder="Введите Название статьи" value="{{old('title', $post ? $post->title : '')}}">
</div>
<div class="form-group">
    <label for="inputBody">Краткое описание статьи</label>
    <input type="text" class="form-control" id="inputSBody" name="short_body" placeholder="Введите Краткое описание" value="{{old('short_body', $post ? $post->short_body : '')}}">
</div>
<div class="form-group">
    <label for="inputBody">Описание статьи</label>
    <input type="text" class="form-control" id="inputBody" name="body" placeholder="Введите описание" value="{{old('body', $post ? $post->body : '')}}">
</div>

<div class="form-group">
    <label for="inputTag">Tags</label>
    <input class="form-control"
           type="text"
           name="tags"
           id="inputTags"
           value="{{ old('tags', $post ? $post->tags->pluck('name')->implode(',') :  '') }}"
    >
</div>
<div class="form-group">
    <input type="checkbox" class="form-check-input"  name="published" {{old('published', $post ? $post->published : '') ? 'checked' : ''}}  id="published">
    <label class="form-check-label" for="published">Опубликовано</label>
</div>
