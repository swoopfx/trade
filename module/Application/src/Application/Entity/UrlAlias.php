<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UrlAlias
 *
 * @ORM\Table(name="url_alias", indexes={@ORM\Index(name="keyword", columns={"keyword"}), @ORM\Index(name="query", columns={"query"})})
 * @ORM\Entity
 */
class UrlAlias
{
    /**
     * @var int
     *
     * @ORM\Column(name="url_alias_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $urlAliasId;

    /**
     * @var string
     *
     * @ORM\Column(name="query", type="string", length=255, nullable=false)
     */
    private $query;

    /**
     * @var string
     *
     * @ORM\Column(name="keyword", type="string", length=255, nullable=false)
     */
    private $keyword;


}
