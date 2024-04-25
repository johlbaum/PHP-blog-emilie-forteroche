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
                        <a href="index.php?action=statistics&sortBy=title&sortOrder=desc">
                            <span class="<?php echo $sortOrder === "desc" && $sortBy === "title" ? "activeSortIndicator" : "sortIndicator " ?>"><i class="fa-solid fa-arrow-down"></i></span>
                        </a>
                        <a href="index.php?action=statistics&sortBy=title&sortOrder=asc">
                            <span class="<?php echo $sortOrder === "asc" && $sortBy === "title" ? "activeSortIndicator" : "sortIndicator " ?>"><i class="fa-solid fa-arrow-up"></i></span>
                        </a>
                    </div>
                </div>
            </th>
            <th>
                <div class="tableHeader">
                    <p>Nombre de vues</p>
                    <div class="tableIcons">
                        <a href="index.php?action=statistics&sortBy=views&sortOrder=desc">
                            <span class="<?php echo $sortOrder === "desc" && $sortBy === "views" ? "activeSortIndicator" : "sortIndicator " ?>"><i class="fa-solid fa-arrow-down"></i></span>
                        </a>
                        <a href="index.php?action=statistics&sortBy=views&sortOrder=asc">
                            <span class="<?php echo $sortOrder === "asc" && $sortBy === "views" ? "activeSortIndicator" : "sortIndicator " ?>"><i class="fa-solid fa-arrow-up"></i></span>
                        </a>
                    </div>
                </div>
            </th>
            <th>
                <div class="tableHeader">
                    <p>Nombre de commentaires</p>
                    <div class="tableIcons">
                        <a href="index.php?action=statistics&sortBy=comments_count&sortOrder=desc">
                            <span class="<?php echo $sortOrder === "desc" && $sortBy === "comments_count" ? "activeSortIndicator" : "sortIndicator" ?>"><i class="fa-solid fa-arrow-down"></i></span>
                        </a>
                        <a href="index.php?action=statistics&sortBy=comments_count&sortOrder=asc">
                            <span class="<?php echo $sortOrder === "asc" && $sortBy === "comments_count" ? "activeSortIndicator" : "sortIndicator" ?>"><i class="fa-solid fa-arrow-up"></i></span>
                        </a>
                    </div>
                </div>
            </th>
            <th>
                <div class="tableHeader">
                    <p>Date de publication</p>
                    <div class="tableIcons">
                        <a href="index.php?action=statistics&sortBy=date_creation&sortOrder=desc">
                            <span class="<?php echo $sortOrder === "desc" && $sortBy === "date_creation" ? "activeSortIndicator" : "sortIndicator" ?>"><i class="fa-solid fa-arrow-down"></i></span>
                        </a>
                        <a href="index.php?action=statistics&sortBy=date_creation&sortOrder=asc">
                            <span class="<?php echo $sortOrder === "asc" && $sortBy === "date_creation" ? "activeSortIndicator" : "sortIndicator" ?>"><i class="fa-solid fa-arrow-up"></i></span>
                        </a>
                    </div>
                </div>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $rowCount = 0;
        foreach ($articles as $article) {
            $rowCount++;
        ?>
            <tr <?= $rowCount % 2 === 0 ? 'class="evenRow"' : 'class="oddRow"' ?>>
                <td><?= $article->getTitle() ?></td>
                <td><?= $article->getViews() ?></td>
                <td><?= $article->getCommentsCount() ?></td>
                <td><?= Utils::convertDateToFrenchFormat($article->getDateCreation()) ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>