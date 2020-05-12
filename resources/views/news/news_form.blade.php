@php
    $news = $news ?? null;
@endphp

<div class="form-group">
    <label for="inputTitle">Символьный код</label>
    <input type="text" class="form-control" id="inputSlug" name="slug" placeholder="Введите Символьный код" value="{{old('slug', $news ? $news->slug : '')}}">
</div>
<div class="form-group">
    <label for="inputTitle">Название новости </label>
    <input type="text" class="form-control" id="inputTitle" name="title" placeholder="Введите Название статьи" value="{{old('title', $news ? $news->title : '')}}">
</div>
<div class="form-group">
    <label for="inputBody">Краткое описание новости</label>
    <input type="text" class="form-control" id="inputSBody" name="short_body" placeholder="Введите Краткое описание" value="{{old('short_body', $news ? $news->short_body : '')}}">
</div>
<div class="form-group">
    <label for="inputBody">Описание новости</label>
    <input type="text" class="form-control" id="inputBody" name="body" placeholder="Введите описание" value="{{old('body', $news ? $news->body : '')}}">
</div>

<div class="form-group">
    <label for="inputTag">Tags</label>
    <input class="form-control"
           type="text"
           name="tags"
           id="inputTags"
           value="{{ old('tags', $news ? $news->tags->pluck('name')->implode(',') :  '') }}"
    >
</div>
<div class="form-group">
    <input type="checkbox" class="form-check-input"  name="published" {{old('published', $news ? $news->published : '') ? 'checked' : ''}}  id="published">
    <label class="form-check-label" for="published">Опубликовано</label>
</div>
