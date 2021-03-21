<form action="" method="POST">
    <?= $form->input('name', 'Titre'); ?>
    <?= $form->input('slug', 'URL'); ?>
    <?= $form->select('categories_ids', 'Catégories', $categories); ?>
    <?= $form->textarea('content', 'Contenu'); ?>
    <?= $form->input('created_at', 'Date de création'); ?>
    
    <button class="btn btn-primary">Envoyer</button>
</form></h1>