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
        $sql = "INSERT INTO article (id_user, title, content, date_creation) VALUES (:id_user, :title, :content, NOW())";
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
     * Récupère le total des vues pour chaque article.
     * @return array : un tableau associatif avec l'ID de chaque article comme clé et le total des vues pour cet article comme valeur.
     */
    public function getViewsCountByArticles(): array
    {
        $sql = "SELECT id, views FROM article";
        $result = $this->db->query($sql);
        $articleViews = [];

        while ($article = $result->fetch(PDO::FETCH_OBJ)) {
            $articleViews[$article->id] = $article->views;
        }

        return $articleViews;
    }

    /**
     * Récupère le total des vues triées pour chaque article.
     * @param string $orderDirection : l'ordre dans lequel on souhaite trier les vues.
     * @return array : un tableau associatif avec l'ID de chaque article comme clé et le total des vues pour cet article comme valeur, triés par ordre croissant ou décroissant.
     */
    public function getSortedViewsCountByArticles(string $orderDirection): array
    {
        $sql = "SELECT *, SUM(views) AS total_views FROM article GROUP BY id ORDER BY total_views $orderDirection";
        $result = $this->db->query($sql);
        $sortedViewsCountByArticles = [];

        while ($article = $result->fetch()) {
            $sortedViewsCountByArticles[] = new Article($article);
        }

        return $sortedViewsCountByArticles;
    }

    /**
     * Incrémente le nombre de vues d'un article de 1 lors de sa consutation.
     * @param int $id : l'id de l'article pour lequel on augmente le nombre de vues.
     * @return void
     */
    public function incrementArticleViews(int $id): void
    {
        $sql = "UPDATE article SET views = views + 1 WHERE id = :article_id";
        $this->db->query($sql, ['article_id' => $id]);
    }

    /**
     * Récupère les articles triés par date de création croissante ou décroissante.. 
     * @param string $orderDirection : l'ordre dans lequel on souhaite trier les articles.
     * @return array
     */
    public function getSortedArticlesByCreationDate(string $orderDirection): array
    {
        $sql = "SELECT * FROM article ORDER BY date_creation $orderDirection";
        $result = $this->db->query($sql);
        $articlesByCreationDate = [];

        while ($article = $result->fetch()) {
            $articlesByCreationDate[] = new Article($article);
        }

        return $articlesByCreationDate;
    }
}
