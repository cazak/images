<?php

namespace App\Model\Images\Feed\Domain\Entity;

use App\Model\Images\Author\Domain\Entity\Author as AuthorEntity;
use App\Model\Images\Domain\Entity\Post\Post as PostEntity;
use App\Model\Shared\Domain\Entity\ValueObject\Id;
use DateTimeImmutable;

trait FeedAnemic
{
    public function getId(): Id
    {
        return $this->id;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(DateTimeImmutable $date): void
    {
        $this->date = $date;
    }

    public function getReader(): AuthorEntity
    {
        return $this->reader;
    }

    public function setReader(AuthorEntity $reader): void
    {
        $this->reader = $reader;
    }

    public function getPost(): PostEntity
    {
        return $this->post;
    }

    public function setPost(PostEntity $post): void
    {
        $this->post = $post;
    }

    public function getPostData(): Post
    {
        return $this->postData;
    }

    public function setPostData(Post $postData): void
    {
        $this->postData = $postData;
    }

    public function getAuthor(): AuthorEntity
    {
        return $this->author;
    }

    public function setAuthor(AuthorEntity $author): void
    {
        $this->author = $author;
    }

    public function getAuthorData(): Author
    {
        return $this->authorData;
    }

    public function setAuthorData(Author $authorData): void
    {
        $this->authorData = $authorData;
    }
}
