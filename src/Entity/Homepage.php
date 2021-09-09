<?php

namespace App\Entity;

use App\Repository\HomepageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HomepageRepository::class)
 */
class Homepage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titleAbout;

    /**
     * @ORM\Column(type="text")
     */
    private $textAbout;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getTitleAbout(): ?string
    {
        return $this->titleAbout;
    }

    public function setTitleAbout(string $titleAbout): self
    {
        $this->titleAbout = $titleAbout;

        return $this;
    }

    public function getTextAbout(): ?string
    {
        return $this->textAbout;
    }

    public function setTextAbout(string $textAbout): self
    {
        $this->textAbout = $textAbout;

        return $this;
    }
}
