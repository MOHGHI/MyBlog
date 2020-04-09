 <div class="col-md-8 blog-main">
        <h3 class="pb-4 mb-4 font-italic border-bottom">
            Add Comment
        </h3>
        @include('errors.errors')
        <form method="post" action="/post/comments">
            @csrf
            <div class="form-group">
                <label for="inputTitle">Title</label>
                <input type="text" class="form-control" name="title" id="inputTitle" placeholder="Title">
            </div>
            <div class="form-group">
                <label for="inputComment">Comment </label>
                <textarea class="form-control" name="comment" id="inputComment" placeholder="Comment"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add comment</button>
        </form>
 </div>
