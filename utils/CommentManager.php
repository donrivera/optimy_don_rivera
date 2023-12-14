<?php
require_once(ROOT . '/utils/DB.php');
require_once(ROOT . '/class/Comment.php');

class CommentManager
{
    private $db;

    private static $instance = null;

	/**
	 * dependency injection db
	 */
    private function __construct(DB $db)
    {
        $this->db = $db;
    }

	/**
	 * get instance
	 */
    public static function getInstance(DB $db)
    {
        if (null === self::$instance) {
            $c = __CLASS__;
            self::$instance = new $c($db);
        }
        return self::$instance;
    }

	/**
	 * list comments
	 */
    public function listComments()
    {
        $rows = $this->db->select('SELECT * FROM `comment`');

        $comments = [];
        foreach ($rows as $row) {
            $n = new Comment();
            $comments[] = $n->setId($row['id'])
                ->setBody($row['body'])
                ->setCreatedAt($row['created_at'])
                ->setNewsId($row['news_id']);
        }

        return $comments;
    }

	/**
	 * add comment for news
	 */
    public function addCommentForNews($body, $newsId)
    {
        $sql = "INSERT INTO `comment` (`body`, `created_at`, `news_id`) VALUES (?, ?, ?)";
        $params = [$body, date('Y-m-d'), $newsId];

        $this->db->exec($sql, $params);
        return $this->db->lastInsertId();
    }

	/**
	 * delete comment
	 */
    public function deleteComment($id)
    {
        $sql = "DELETE FROM `comment` WHERE `id` = ?";
        $params = [$id];

        return $this->db->exec($sql, $params);
    }
}