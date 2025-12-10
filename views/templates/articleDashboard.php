<?php 
    /** 
     * Affichage de la partie admin, statistiques : liste des articles avec le nombre de vues, de commentaires et la date de publication de l'article
     * Et un formulaire pour ajouter un article. 
     */
?>

<h2>Statistiques des articles</h2>

<div class="adminArticle">
        <div class="articleLine">
            <div class="title">Titre</div>
            <div class="title">Nombre de vues</div>
            <div class="title">Nombre de commentaires</div>
            <div class="title">Date de création</div>
        </div>
    <?php foreach ($articles as $article) { ?>
        <div class="articleLine">
            <div class="title"><?= $article->getTitle() ?></div>
            <div class="title"><?= $article->getViewsNumber() ?></div>
            <div class="title"><?= $article->getCommentsNumber() ?></div>
            <div class="title"><?= Utils::convertDateToFrenchFormat($article->getDateCreation()) ?></div>
        </div>
    <?php } ?>
</div>