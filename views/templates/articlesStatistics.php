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
            <th>
                <div class="tableHeader">
                    <p>Titre de l'article</p>
                    <div class="tableIcons">
                        <a href="index.php?action=statistics&type=article&sortby=desc">
                            <span class="<?php echo $sortBy === "desc" && $type === "article" ? "activeSortIndicator" : "sortIndicator " ?>"><i class="fa-solid fa-arrow-down"></i></span>
                        </a>
                        <a href="index.php?action=statistics&type=article&sortby=asc">
                            <span class="<?php echo $sortBy === "asc" && $type === "article" ? "activeSortIndicator" : "sortIndicator " ?>"><i class="fa-solid fa-arrow-up"></i></span>
                        </a>
                    </div>
                </div>
            </th>
            <th>
                <div class="tableHeader">
                    <p>Nombre de vues</p>
                    <div class="tableIcons">
                        <a href="index.php?action=statistics&type=views&sortby=desc">
                            <span class="<?php echo $sortBy === "desc" && $type === "views" ? "activeSortIndicator" : "sortIndicator " ?>"><i class="fa-solid fa-arrow-down"></i></span>
                        </a>
                        <a href="index.php?action=statistics&type=views&sortby=asc">
                            <span class="<?php echo $sortBy === "asc" && $type === "views" ? "activeSortIndicator" : "sortIndicator " ?>"><i class="fa-solid fa-arrow-up"></i></span>
                        </a>
                    </div>
                </div>
            </th>
            <th>
                <div class="tableHeader">
                    <p>Nombre de commentaires</p>
                    <div class="tableIcons">
                        <a href="index.php?action=statistics&type=comment&sortby=desc">
                            <span class="<?php echo $sortBy === "desc" && $type === "comment" ? "activeSortIndicator" : "sortIndicator" ?>"><i class="fa-solid fa-arrow-down"></i></span>
                        </a>
                        <a href="index.php?action=statistics&type=comment&sortby=asc">
                            <span class="<?php echo $sortBy === "asc" && $type === "comment" ? "activeSortIndicator" : "sortIndicator" ?>"><i class="fa-solid fa-arrow-up"></i></span>
                        </a>
                    </div>
                </div>
            </th>
            <th>
                <div class="tableHeader">
                    <p>Date de publication</p>
                    <div class="tableIcons">
                        <a href="index.php?action=statistics&type=date&sortby=desc">
                            <span class="<?php echo $sortBy === "desc" && $type === "date" ? "activeSortIndicator" : "sortIndicator" ?>"><i class="fa-solid fa-arrow-down"></i></span>
                        </a>
                        <a href="index.php?action=statistics&type=date&sortby=asc">
                            <span class="<?php echo $sortBy === "asc" && $type === "date" ? "activeSortIndicator" : "sortIndicator" ?>"><i class="fa-solid fa-arrow-up"></i></span>
                        </a>
                    </div>
                </div>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($articles as $article) {
        ?>
            <tr>
                <td><?= $article->getTitle() ?></td>
                <td><?= $article->getViews() ?></td>
                <td><?= $commentsCountByArticles[$article->getId()] ?></td>
                <td><?= Utils::convertDateToFrenchFormat($article->getDateCreation()) ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>