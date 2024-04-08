<?php

/**
 * Classe qui permet de gérer les données statistiques des articles.
 */
class StatisticsService
{
    private CommentManager $commentManager;
    private ArticleManager $articleManager;

    private array $articles;
    private array $totalCommentsByArticles;
    private array $totalViewsByArticles;

    public function __construct(CommentManager $commentManager, ArticleManager $articleManager)
    {
        $this->commentManager = $commentManager;
        $this->articleManager = $articleManager;

        $this->articles = $this->articleManager->getAllArticles();
        $this->totalCommentsByArticles = $this->commentManager->getTotalCommentsByArticles($this->articles);
        $this->totalViewsByArticles = $this->articleManager->getTotalViewsByArticles();
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
    public function getTotalCommentsByArticles(): array
    {
        return $this->totalCommentsByArticles;
    }

    /**
     * Getter pour le nombre total de vues des articles.
     * @return int : un tableau associatif avec l'ID de chaque article comme clé et le total des vues pour cet article comme valeur.
     */
    public function getTotalViewsByArticles(): array
    {
        return $this->totalViewsByArticles;
    }
}
