<?php

/**
 * Classe qui gère les articles.
 */
class ArticleManager extends AbstractEntityManager
{
    /**
     * Récupère tous les articles.
     * @return array : un tableau d'objets Article.
     */
    public function getAllArticles(): array
    {
        $sql = "SELECT * FROM article";
        $result = $this->db->query($sql);
        $articles = [];

        while ($article = $result->fetch()) {
            $articles[] = new Article($article);
        }

        return $articles;
    }

    /**
     * Récupère un article par son id.
     * @param int $id : l'id de l'article.
     * @return Article|null : un objet Article ou null si l'article n'existe pas.
     */
    public function getArticleById(int $id): ?Article
    {
        $sql = "SELECT * FROM article WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $article = $result->fetch();
        if ($article) {
            return new Article($article);
        }

        return null;
    }

    /**
     * Ajoute ou modifie un article.
     * On sait si l'article est un nouvel article car son id sera -1.
     * @param Article $article : l'article à ajouter ou modifier.
     * @return void
     */
    public function addOrUpdateArticle(Article $article): void
    {
        if ($article->getId() == -1) {
            $this->addArticle($article);
        } else {
            $this->updateArticle($article);
        }
    }

    /**
     * Ajoute un article.
     * @param Article $article : l'article à ajouter.
     * @return void
     */
    public function addArticle(Article $article): void
    {
        $sql = "INSERT INTO article (id_user, title, content, date_creation, date_update) VALUES (:id_user, :title, :content, NOW(), NOW())";
        $this->db->query($sql, [
            'id_user' => $article->getIdUser(),
            'title' => $article->getTitle(),
            'content' => $article->getContent()
        ]);
    }

    /**
     * Modifie un article.
     * @param Article $article : l'article à modifier.
     * @return void
     */
    public function updateArticle(Article $article): void
    {
        $sql = "UPDATE article SET title = :title, content = :content, date_update = NOW() WHERE id = :id";
        $this->db->query($sql, [
            'title' => $article->getTitle(),
            'content' => $article->getContent(),
            'id' => $article->getId()
        ]);
    }

    /**
     * Supprime un article.
     * @param int $id : l'id de l'article à supprimer.
     * @return void
     */
    public function deleteArticle(int $id): void
    {
        $sql = "DELETE FROM article WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);
    }

    /**
     * Incrémente le nombre de vues d'un article de 1 lors de sa consultation.
     * @param int $id : l'id de l'article pour lequel on augmente le nombre de vues.
     * @return void
     */
    public function incrementArticleViews(int $id): void
    {
        $sql = "UPDATE article SET views = views + 1 WHERE id = :article_id";
        $this->db->query($sql, ['article_id' => $id]);
    }

    /**
     * Récupère tous les articles avec le nombre de commentaires associés à chaque article. 
     * @return array : un tableau d'objets Article.
     */
    public function getArticlesWithCommentsCount(): array
    {
        $sql = "SELECT 
                    article.*,
                    COUNT(comment.id) AS comments_count
                FROM 
                    article
                LEFT JOIN 
                    comment
                ON
                    article.id = comment.id_article
                GROUP BY
                    article.id
                ";
        $result = $this->db->query($sql);
        $articleswithCommentsCount = [];

        while ($article = $result->fetch()) {
            $articleswithCommentsCount[] = new Article($article);
        }

        return $articleswithCommentsCount;
    }

    /**
     * Récupère tous les articles triés avec le nombre de commentaires associés à chaque article.
     * @param string $sortBy : le critère de tri (tri par titre, vues, nombre de commentaires et date de création).
     * @param string $sortOrder : l'ordre dans lequel on souhaite trier les articles (croissant ou décroissant).
     * @return array : un tableau d'objets Article.
     */
    public function getSortedArticlesWithCommentsCount(string $sortBy, string $sortOrder): array
    {
        $sql = "SELECT 
                    article.*,
                    COUNT(comment.id) AS comments_count
                FROM 
                    article
                LEFT JOIN 
                    comment
                ON
                    article.id = comment.id_article
                GROUP BY
                    article.id
                ORDER BY 
                    $sortBy $sortOrder
                ";
        $result = $this->db->query($sql);
        $sortedArticlesWithCommentsCount = [];

        while ($article = $result->fetch()) {
            $sortedArticlesWithCommentsCount[] = new Article($article);
        }

        return $sortedArticlesWithCommentsCount;
    }
}
