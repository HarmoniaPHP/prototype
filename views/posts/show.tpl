{extends "layouts/app.tpl"}

{block 'content'}
    <h1 class="h3 mb-3">{$post['title']|escape}</h1>
    <p>{$post['content']|escape}</p>
{/block}
