<?php $message = getFlashMessage(); if(isset($message)): ?>
    <blockquote class="blockquote blockquote-<?= $message['type'] ?>">
        <p class="text-<?= $message['type'] ?>"><?= $message['message'] ?></p>
    </blockquote>
<?php endif; ?>

