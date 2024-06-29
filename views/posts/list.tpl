{extends "layouts/app.tpl"}

{block 'content'}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Posts</h1>
        <a href="/posts/create" class="btn btn-primary">New post</a>
    </div>
    <ul class="list-unstyled">
        {foreach $posts as $post}
            <li class="d-flex justify-content-between align-items-center w-100">
                <a href="/posts/{$post@index+1}" class="text-decoration-none border p-3 rounded mb-3 w-100">
                    <h2 class="h5 mb-0">{$post['title']|escape}</h2>
                </a>
            </li>
        {/foreach}
    </ul>
{/block}
