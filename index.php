<?php

define('ROOT', __DIR__);
require_once(ROOT . '/utils/NewsManager.php');
require_once(ROOT . '/utils/CommentManager.php');

$newsManager = NewsManager::getInstance();
$commentManager = CommentManager::getInstance();

foreach ($newsManager->listNews() as $news) {
	echo("############ NEWS " . $news->getTitle() . " ############\n");
	echo($news->getBody() . "\n");
	foreach ($commentManager->listComments() as $comment) {
		if ($comment->getNewsId() == $news->getId()) {
			echo("Comment " . $comment->getId() . " : " . $comment->getBody() . "\n");
		}
	}
}

$c = $commentManager->listComments();