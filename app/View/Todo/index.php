<div class="title">
    <h2><?= empty($message) ? 'TODO list:' : $message ?></h2>
</div>
<?php if (empty($todos)) { ?>
    <p>Nothing found. Do you want to <a href="<?= BASE_URL ?>todo/add">add one todo</a>?</p>
<?php } else { ?>
    <p>This is the list of registered TODOs. You can start <a href="<?= BASE_URL ?>todo/add">adding one</a>.</p>
    <table id="todos">
        <tr>
            <th>Description</th>
            <th>Created</th>
            <th>Finished</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($todos as $todo) { ?>
            <tr>
                <td><?= $todo->description ?></td>
                <td><?= $todo->created ?></td>
                <td><?php
                    if (empty($todo->finished)) {
                        echo '<a href="' . BASE_URL . 'todo/finish/' . $todo->id . '">finish now</a>';
                    } else {
                        echo $todo->finished;
                    }
                    ?></td>
                <td>
                    <a href="<?= BASE_URL ?>todo/copy/<?= $todo->id ?>">copy</a>
                    <a href="<?= BASE_URL ?>todo/edit/<?= $todo->id ?>">edit</a>
                    <a href="<?= BASE_URL ?>todo/delete/<?= $todo->id ?>">del</a>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>
