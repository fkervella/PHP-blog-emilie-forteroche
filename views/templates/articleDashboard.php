<?php 
    /** 
     * Affichage de la partie admin, statistiques : liste des articles avec le nombre de vues, de commentaires et la date de publication de l'article
     * Et un formulaire pour ajouter un article. 
     */
?>

<h2>Statistiques des articles</h2>

<div class="adminArticle">
        <div class="articleLine">
            <div class="title">Titre <a href="index.php?action=showArticlesStats&column=title&way=0"><font size = '5'>&darr;</font></a> <a href="index.php?action=showArticlesStats&column=title&way=1"><font size = '5'>&uarr;</font></a></div>
            <div class="title">Nombre de vues <a href="index.php?action=showArticlesStats&column=viewsNumber&way=0"><font size = '5'>&darr;</font></a> <a href="index.php?action=showArticlesStats&column=viewsNumber&way=1"><font size = '5'>&uarr;</font></a></div>
            <div class="title">Nombre de commentaires <a href="index.php?action=showArticlesStats&column=commentsNumber&way=0"><font size = '5'>&darr;</font></a> <a href="index.php?action=showArticlesStats&column=commentsNumber&way=1"><font size = '5'>&uarr;</font></a></div>
            <div class="title">Date de création <a href="index.php?action=showArticlesStats&column=dateCreation&way=0"><font size = '5'>&darr;</font></a> <a href="index.php?action=showArticlesStats&column=dateCreation&way=1"><font size = '5'>&uarr;</font></a></div>
        </div>

    <?php $coloredLine = 0; ?>
    <?php foreach ($articles as $article) { ?>
        <?php if($coloredLine === 1 ) {
            echo '<div class="articleLine">';
            $coloredLine = 0;
         } else {
            echo '<div class="articleBlankLine">';
            $coloredLine = 1;
        }
        ?>
            <div class="title"><a href="index.php?action=showArticle&id=<?= $article->getId() ?>"><?= $article->getTitle() ?></a></div>
            <div class="title"><?= $article->getViewsNumber() ?></div>
            <div class="title"><?= $article->getCommentsNumber() ?></div>
            <div class="title"><?= Utils::convertDateToFrenchFormat($article->getDateCreation()) ?></div>
        </div>
    <?php } ?>
</div>