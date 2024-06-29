{extends "layouts/app.tpl"}

{block 'content'}
    <h1 class="h3 mb-3">New post</h1>
    <form action="/posts/store" method="post">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" id="title" aria-describedby="titleHelp" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea name="content" class="form-control" id="content" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
{/block}
