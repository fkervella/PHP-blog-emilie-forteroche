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
    public function getAllArticles() : array
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
    public function getArticleById(int $id) : ?Article
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
    public function addOrUpdateArticle(Article $article) : void 
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
    public function addArticle(Article $article) : void
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
    public function updateArticle(Article $article) : void
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
    public function deleteArticle(int $id) : void
    {
        $sql = "DELETE FROM article WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);
    }

    /**
     * Met à jour le nombre de vues d'un article.
     * @param int $id : l'id de l'article dont le nombre de vues est à incrémenteer.
     * @return void
     */
    public function incrementArticleViewsNumber(int $id) : void
    {
        $sql = "UPDATE article SET views_number = views_number + 1 WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);
    }

    /**
     * Récupère tous les articles avec les statistiques articles associées.
     * @return array : un tableau d'objets Article.
     */
    public function getAllArticlesWithStats(?string $column, ?string $way) : array
    {
        switch($column) {
            case 'title':
                $columnName = "article.title";
                break;
            
            case 'dateCreation':
                $columnName = "article.date_creation";
                break;
            
            case 'viewsNumber':
                $columnName = "article.views_number";
                break;
            
            case 'commentsNumber':
                $columnName = "comments_number";
                break;
            
            default:
                $columnName = 'comments_number';
                break;
        }

        switch($way) {
            case '1':
                $wayName = "ASC";
                break;

            case '0':
                $wayName = "DESC";
                break;

            default:
                $wayName = "ASC";
                break;

        }

        $sql = "SELECT article.id as 'id', article.title as 'title', article.date_creation as 'date_creation', article.views_number as 'views_number', count(comment.id) as 'comments_number' FROM article LEFT JOIN comment ON article.id = comment.id_article GROUP BY article.id ORDER BY $columnName $wayName";
        $result = $this->db->query($sql);
        $articles = [];

        while ($article = $result->fetch()) {
            $articles[] = new Article($article);
        }
        return $articles;
    }    
}