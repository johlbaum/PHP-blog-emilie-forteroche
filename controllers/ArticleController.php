<?php

class ArticleController
{
    /**
     * Affiche la page d'accueil.
     * @return void
     */
    public function showHome(): void
    {
        $articleManager = new ArticleManager();
        $articles = $articleManager->getAllArticles();

        $view = new View("Accueil");
        $view->render("home", ['articles' => $articles]);
    }

    /**
     * Affiche le détail d'un article.
     * @return void
     */
    public function showArticle(): void
    {
        // Récupération de l'id de l'article demandé.
        $id = Utils::request("id", -1);

        $articleManager = new ArticleManager();
        $article = $articleManager->getArticleById($id);

        if (!$article) {
            throw new Exception("L'article demandé n'existe pas.");
        }

        $commentManager = new CommentManager();
        $comments = $commentManager->getAllCommentsByArticleId($id);

        // Incrémentation du nombre de vues de 1 lors de la consultation d'un article, seulement si l'administrateur n'est pas connecté.
        if (!isset($_SESSION['user'])) {
            $articleManager->incrementArticleViews($id);
        }

        $view = new View($article->getTitle());
        $view->render(
            "detailArticle",
            [
                'article' => $article,
                'comments' => $comments,
                'isConnected' => isset($_SESSION['user'])
            ]
        );
    }

    /**
     * Affiche le formulaire d'ajout d'un article.
     * @return void
     */
    public function addArticle(): void
    {
        $view = new View("Ajouter un article");
        $view->render("addArticle");
    }

    /**
     * Affiche la page "à propos".
     * @return void
     */
    public function showApropos(): void
    {
        $view = new View("A propos");
        $view->render("apropos");
    }
}
