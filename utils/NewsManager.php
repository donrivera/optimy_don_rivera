<?php
require_once(ROOT . '/utils/DB.php');
require_once(ROOT . '/utils/CommentManager.php');
require_once(ROOT . '/class/News.php');

class NewsManager
{
    private $db;
    private $commentManager;

    private static $instance = null;

	/**
	 * Dependency Injection DB and comment
	 */
    private function __construct(DB $db, CommentManager $commentManager)
    {
        $this->db = $db;
        $this->commentManager = $commentManager;
    }

	/**
	 * get instance 
	 */
    public static function getInstance(DB $db, CommentManager $commentManager)
    {
        if (null === static::$instance) {
            static::$instance = new static($db, $commentManager);
        }
        return static::$instance;
    }

	/**
	* list all news
	*/
    public function listNews()
    {
        $rows = $this->db->select('SELECT * FROM `news`');

        $news = [];
        foreach ($rows as $row) {
            $n = new News();
            $news[] = $n->setId($row['id'])
                ->setTitle($row['title'])
                ->setBody($row['body'])
                ->setCreatedAt($row['created_at']);
        }

        return $news;
    }

	/**
	* add a record in news table
	*/
    public function addNews($title, $body)
    {
        $sql = "INSERT INTO `news` (`title`, `body`, `created_at`) VALUES (?, ?, ?)";
        $params = [$title, $body, date('Y-m-d')];

        $this->db->exec($sql, $params);
        return $this->db->lastInsertId();
    }

	/**
	* deletes a news, and also linked comments
	*/
    public function deleteNews($id)
    {
        $comments = $this->commentManager->listComments();
        $idsToDelete = [];

        foreach ($comments as $comment) {
            if ($comment->getNewsId() == $id) {
                $idsToDelete[] = $comment->getId();
            }
        }

        foreach ($idsToDelete as $idToDelete) {
            $this->commentManager->deleteComment($idToDelete);
        }

        $sql = "DELETE FROM `news` WHERE `id` = ?";
        $params = [$id];

        return $this->db->exec($sql, $params);
    }
}