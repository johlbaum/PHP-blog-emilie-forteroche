<?php

/**
 * Classe gére les données statistiques des articles.
 */
class StatisticsService
{
    const SORT_ASC = 'asc';
    const SORT_DESC = 'desc';

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
        switch ($type) {
            case "title":
                $this->updateArticleOrderByTitle($sortBy);
                break;
            case "comment":
                $this->updateCommentsCountOrder($sortBy);
                break;
            case "views":
                $this->updateViewsCountOrder($sortBy);
                break;
            case "date":
                $this->updateArticleOrderByCreationDate($sortBy);
                break;
            default:
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
        if ($sortBy === self::SORT_ASC || $sortBy === self::SORT_DESC) {
            $sortedCommentsCountByArticle = $this->commentManager->getSortedCommentsCountByArticles($sortBy);
            $this->commentsCountByArticles = $sortedCommentsCountByArticle;
        } else {
            throw new Exception("Ordre de tri invalide.");
        }

        $this->updateArticlesOrderAfterCommentsSort($this->commentsCountByArticles);
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
        if ($sortBy === self::SORT_ASC || $sortBy === self::SORT_DESC) {
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
    private function updateArticleOrderByCreationDate(string $sortBy): void
    {
        if ($sortBy === self::SORT_ASC || $sortBy === self::SORT_DESC) {
            $sortedArticleByCreationDate = $this->articleManager->getSortedArticlesByCreationDate($sortBy);
            $this->articles = $sortedArticleByCreationDate;
        } else {
            throw new Exception("Ordre de tri invalide.");
        }
    }

    /**
     * Mets à jour le tableau d'articles en le triant par titre.
     * @param string $sortBy : l'ordre dans lequel on souhaite trier les titres.
     * @return void
     */
    private function updateArticleOrderByTitle(string $sortBy): void
    {
        if ($sortBy === self::SORT_ASC || $sortBy === self::SORT_DESC) {
            $sortedArticleByTitle = $this->articleManager->getSortedArticlesByTitle($sortBy);
            $this->articles = $sortedArticleByTitle;
        } else {
            throw new Exception("Ordre de tri invalide.");
        }
    }

    /**
     * Getter pour la liste des articles.
     * @return array : un tableau d'objets Article.
     */
    public function getArticles(): array
    {
        return $this->articles;
    }

    /**
     * Getter pour le nombre total de commentaires.
     * @return array : un tableau associatif avec l'ID de chaque article comme clé et le total des commentaires comme valeur.
     */
    public function getCommentsCountByArticles(): array
    {
        return $this->commentsCountByArticles;
    }
}
