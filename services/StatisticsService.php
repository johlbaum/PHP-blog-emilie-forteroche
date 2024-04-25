<?php

/**
 * Classe qui gére les données statistiques des articles.
 */
class StatisticsService
{
    const SORT_ASC = 'asc';
    const SORT_DESC = 'desc';
    private ArticleManager $articleManager;
    private array $articles;

    /**
     * Constructeur de la classe StatisticsService.
     * @param ArticleManager $articleManager : le gestionnaire d'articles.
     */
    public function __construct(ArticleManager $articleManager)
    {
        $this->articleManager = $articleManager;
        $this->articles = $this->articleManager->getArticlesWithCommentsCount();
    }

    /**
     * Méthode pour trier les articles.
     * @param string $sortBy : critères de tri des articles (tri par titre, vues, nombre de commentaires et date de création). 
     * @param string $sortOrder : l'ordre dans lequel on souhaite trier les articles (croissant ou décroissant).
     * @return void
     */
    public function sortArticles(string $sortBy, string $sortOrder): void
    {
        switch ($sortBy) {
            case "title":
            case "views":
            case "comments_count":
            case "date_creation":
                if ($sortOrder === self::SORT_ASC || $sortOrder === self::SORT_DESC) {
                    $sortedArticlesWithCommentsCount = $this->articleManager->getSortedArticlesWithCommentsCount($sortBy, $sortOrder);
                    $this->articles = $sortedArticlesWithCommentsCount;
                } else {
                    throw new Exception("Ordre de tri invalide.");
                }
                break;
            default:
                throw new Exception("Critère de tri invalide.");
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
}
