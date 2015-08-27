<div class="title">
    <h2><?= empty($message) ? 'TODO' : $message ?></h2>
</div>
<p>Your TODO form.</p>
<form id="todo-form" method="POST">
    <input type="hidden" id="todo_id" name="todo_id" value="<?= @$todo->id ?>" />
    <label for="description">Description</label>
    <textarea id="description" name="description"><?= @$todo->description ?></textarea><br/>
    <label for="finished">Done?</label>
    <input type="checkbox" id="finished" name="finished" value="1" <?= empty($todo->finished) ? '' : 'checked="checked"' ?> /><br/>

    <input type="submit" name="Save" value="Save" />
    or
    <a href="<?= BASE_URL ?>todo">Cancel</a>
</form>
