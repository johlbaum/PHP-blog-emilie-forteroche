<?php

/**
 * Cette classe sert à gérer les commentaires. 
 */
class CommentManager extends AbstractEntityManager
{
    /**
     * Récupère tous les commentaires d'un article.
     * @param int $idArticle : l'id de l'article.
     * @return array : un tableau d'objets Comment.
     */
    public function getAllCommentsByArticleId(int $idArticle): array
    {
        $sql = "SELECT * FROM comment WHERE id_article = :idArticle";
        $result = $this->db->query($sql, ['idArticle' => $idArticle]);
        $comments = [];

        while ($comment = $result->fetch()) {
            $comments[] = new Comment($comment);
        }
        return $comments;
    }

    /**
     * Récupère un commentaire par son id.
     * @param int $id : l'id du commentaire.
     * @return Comment|null : un objet Comment ou null si le commentaire n'existe pas.
     */
    public function getCommentById(int $id): ?Comment
    {
        $sql = "SELECT * FROM comment WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $comment = $result->fetch();
        if ($comment) {
            return new Comment($comment);
        }
        return null;
    }

    /**
     * Ajoute un commentaire.
     * @param Comment $comment : l'objet Comment à ajouter.
     * @return bool : true si l'ajout a réussi, false sinon.
     */
    public function addComment(Comment $comment): bool
    {
        $sql = "INSERT INTO comment (pseudo, content, id_article, date_creation) VALUES (:pseudo, :content, :idArticle, NOW())";
        $result = $this->db->query($sql, [
            'pseudo' => $comment->getPseudo(),
            'content' => $comment->getContent(),
            'idArticle' => $comment->getIdArticle()
        ]);
        return $result->rowCount() > 0;
    }

    /**
     * Supprime un commentaire.
     * @param Comment $comment : l'objet Comment à supprimer.
     * @return bool : true si la suppression a réussi, false sinon.
     */
    public function deleteComment(Comment $comment): bool
    {
        $sql = "DELETE FROM comment WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $comment->getId()]);
        return $result->rowCount() > 0;
    }

    /**
     * Récupère le total des commentaires pour chaque article.
     * @param array $articles : un tableau d'objets Article.
     * @return array : un tableau associatif avec l'ID de chaque article comme clé et le total des commentaires pour cet article comme valeur.
     */
    public function getCommentsCountByArticles(array $articles): array
    {
        $commentsCountByArticles = [];

        foreach ($articles as $article) {
            $allCommentsByArticleId = $this->getAllCommentsByArticleId($article->getId());
            $commentsCountByArticles[$article->getId()] = count($allCommentsByArticleId);
        }
        return $commentsCountByArticles;
    }

    /**
     * Récupère le total des commentaires triés pour chaque article.
     * @param string $orderDirection : l'ordre dans lequel on souhaite trier les commentaires.
     * @return array : un tableau associatif avec l'ID de chaque article comme clé et le total des commentaires pour cet article comme valeur triés par ordre croissant ou décroissant.
     */
    public function getSortedCommentsCountByArticles(string $orderDirection): array
    {
        $sql = "SELECT id_article, COUNT(*) AS total_comments FROM comment GROUP BY id_article ORDER BY total_comments $orderDirection";
        $result = $this->db->query($sql);
        $sortedCommentsCountByArticles = [];

        while ($article = $result->fetch(PDO::FETCH_OBJ)) {
            $sortedCommentsCountByArticles[$article->id_article] = $article->total_comments;
        }
        return $sortedCommentsCountByArticles;
    }
}
