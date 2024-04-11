<?php

/**
 * Classe gére les données statistiques des articles.
 */
class StatisticsService
{
    private CommentManager $commentManager;
    private ArticleManager $articleManager;

    private array $articles;
    private array $commentsCountByArticles;

    /**
     * Constructeur de la classe StatisticsService.
     * @param CommentManager $commentManager : le gestionnaire de commentaires.
     * @param ArticleManager $articleManager : le gestionnaire d'articles.
     */
    public function __construct(CommentManager $commentManager, ArticleManager $articleManager)
    {
        $this->commentManager = $commentManager;
        $this->articleManager = $articleManager;

        $this->articles = $this->articleManager->getAllArticles();
        $this->commentsCountByArticles = $this->commentManager->getCommentsCountByArticles($this->articles);
    }

    /**
     * Gestionnaire de méthodes pour effectuer le tri des données.
     * @param string $type : le type de données que l'on souhaite trier. 
     * @param string $sortBy : l'ordre dans lequel on souhaite trier la donnée.
     * @return void
     */
    public function sortManager(string $type, string $sortBy): void
    {
        if ($type === "comment") {
            $this->updateCommentsCountOrder($sortBy);
            $this->updateArticlesOrderAfterCommentsSort($this->commentsCountByArticles);
        } elseif ($type === "views") {
            $this->updateViewsCountOrder($sortBy);
        } elseif ($type === "date") {
            $this->updateArticleByCreationDateOrder($sortBy);
        } else {
            throw new Exception("Type de données invalide.");
        }
    }

    /**
     * Mets à jour le tableau du total des commentaires par article en le classant par ordre croissant ou décroissant.
     * @param string $sortBy : l'ordre dans lequel on souhaite trier les commentaires.
     * @return void
     */
    private function updateCommentsCountOrder($sortBy): void
    {
        if ($sortBy === "asc" || $sortBy === "desc") {
            $sortedCommentsCountByArticle = $this->commentManager->getSortedCommentsCountByArticles($sortBy);
            $this->commentsCountByArticles = $sortedCommentsCountByArticle;
        } else {
            throw new Exception("Ordre de tri invalide.");
        }
    }

    /**
     * Aligne l'ordre des articles que l'on va envoyer à la vue sur l'ordre des articles qui découle du tri des commentaires.
     * @param array $sortedTypeCount : un tableau associatif avec l'ID de chaque article comme clé et le total du type de données (total commentaires, total vues, etc.) comme valeur, triées par ordre croissant ou décroissant.
     * @return void
     */
    private function updateArticlesOrderAfterCommentsSort(array $commentsCountByArticles): void
    {
        $sortedArticles = [];
        foreach ($commentsCountByArticles as $articleId => $count) {
            foreach ($this->articles as $article) {
                if ($article->getId() === $articleId) {
                    $sortedArticles[] = $article;
                    break;
                }
            }
        }

        $this->articles = $sortedArticles;
    }

    /**
     * Mets à jour le tableau du total des vues par article en le classant par ordre croissant ou décroissant.
     * @param string $sortBy : l'ordre dans lequel on souhaite trier les vues.
     * @return void
     */
    private function updateViewsCountOrder(string $sortBy): void
    {
        if ($sortBy === "asc" || $sortBy === "desc") {
            $sortedViewsCountByArticle = $this->articleManager->getSortedViewsCountByArticles($sortBy);
            $this->articles = $sortedViewsCountByArticle;
        } else {
            throw new Exception("Ordre de tri invalide.");
        }
    }

    /**
     * Mets à jour le tableau d'articles en le triant par date.
     * @param string $sortBy : l'ordre dans lequel on souhaite trier les dates.
     * @return void
     */
    private function updateArticleByCreationDateOrder(string $sortBy): void
    {
        if ($sortBy === "asc" || $sortBy === "desc") {
            $sortedArticleByCreationDate = $this->articleManager->getSortedArticlesByCreationDate($sortBy);
            $this->articles = $sortedArticleByCreationDate;
        } else {
            throw new Exception("Ordre de tri invalide.");
        }
    }

    /**
     * Getter pour la liste des articles.
     * @return array : un tableau d'objets Article.
     */
    public function getArticle(): array
    {
        return $this->articles;
    }

    /**
     * Getter pour le nombre total de commentaires.
     * @return array : un tableau associatif avec l'ID de chaque article comme clé et le total des commentaires pour cet article comme valeur.
     */
    public function getCommentsCountByArticles(): array
    {
        return $this->commentsCountByArticles;
    }
}
