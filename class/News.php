<?php

class News
{
	protected $id;
	protected $title;
	protected $body;
	protected $createdAt;

	public function __construct($id = null, $title = null, $body = null, $createdAt = null)
    {
        $this->id = $id;
		$this->title = $title;
        $this->body = $body;
        $this->createdAt = $createdAt;
    }

	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setTitle($title)
	{
		$this->title = $title;

		return $this;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setBody($body)
	{
		$this->body = $body;

		return $this;
	}

	public function getBody()
	{
		return $this->body;
	}

	public function setCreatedAt($createdAt)
	{
		$this->createdAt = $createdAt;

		return $this;
	}

	public function getCreatedAt()
	{
		return $this->createdAt;
	}
}