<?php

/**
 * Template pour afficher le tableau de statistiques des articles.
 */
?>

<div class="adminHeader">
    <h2><a href="index.php?action=admin">Edition des articles</a></h2>
    <h2 class="isActive"><a href="index.php?action=statistic">Statistique des Articles</a></h2>
</div>
<table>
    <thead>
        <tr>
            <th>Titre de l'article</th>
            <th>Nombre de vues</th>
            <th>Nombre de commentaires</th>
            <th>Date de publication</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($articles as $article) { ?>
        <tr>
            <td><?= $article->getTitle() ?></td>
            <td><?= $totalViewsByArticles[$article->getId()] ?></td>
            <td><?= $totalCommentsByArticles[$article->getId()] ?></td>
            <td><?= Utils::convertDateToFrenchFormat($article->getDateCreation()) ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>