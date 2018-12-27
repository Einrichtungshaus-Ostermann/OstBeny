<?php declare(strict_types=1);

/**
 * Einrichtungshaus Ostermann GmbH & Co. KG - Beny
 *
 * @package   OstBeny
 *
 * @author    Eike Brandt-Warneke <e.brandt-warneke@ostermann.de>
 * @copyright 2018 Einrichtungshaus Ostermann GmbH & Co. KG
 * @license   proprietary
 */

namespace OstBeny\Models;

use Doctrine\ORM\Mapping as ORM;
use Shopware\Components\Model\ModelEntity;
use Shopware\Models\Customer\Customer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Repository")
 * @ORM\Table(name="ost_beny_articles",uniqueConstraints={@ORM\UniqueConstraint(name="unique_article", columns={"number", "marketplaceId"})})
 */
class Article extends ModelEntity
{
    /**
     * Auto-generated id.
     *
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * ...
     *
     * @var \DateTime
     *
     * @Assert\DateTime()
     *
     * @ORM\Column(name="`date`", type="datetime")
     */
    private $date;

    /**
     * ...
     *
     * @var string
     *
     * @ORM\Column(name="number", type="string", nullable=false, length=16)
     */
    private $number;

    /**
     * ...
     *
     * @var integer
     *
     * @ORM\Column(name="ranking", type="integer", nullable=false)
     */
    private $ranking;

    /**
     * ...
     *
     * @var float
     *
     * @ORM\Column(name="price", type="float", nullable=false)
     */
    private $price;

    /**
     * ...
     *
     * @var string
     *
     * @ORM\Column(name="competitor", type="string", nullable=false, length=64)
     */
    private $competitor;

    /**
     * OWNING SIDE - UNI DIRECTIONAL
     *
     * ...
     *
     * @var Marketplace
     *
     * @ORM\ManyToOne(targetEntity="OstBeny\Models\Marketplace")
     * @ORM\JoinColumn(name="marketplaceId", referencedColumnName="id")
     */

    protected $marketplace;

    /**
     * ...
     */
    public function __construct()
    {
    }

    /**
     * Getter method for the property.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Getter method for the property.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Setter method for the property.
     *
     * @param \DateTime $date
     *
     * @return void
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Getter method for the property.
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Setter method for the property.
     *
     * @param string $number
     *
     * @return void
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * Getter method for the property.
     *
     * @return int
     */
    public function getRanking()
    {
        return $this->ranking;
    }

    /**
     * Setter method for the property.
     *
     * @param int $ranking
     *
     * @return void
     */
    public function setRanking($ranking)
    {
        $this->ranking = $ranking;
    }

    /**
     * Getter method for the property.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Setter method for the property.
     *
     * @param float $price
     *
     * @return void
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Getter method for the property.
     *
     * @return string
     */
    public function getCompetitor()
    {
        return $this->competitor;
    }

    /**
     * Setter method for the property.
     *
     * @param string $competitor
     *
     * @return void
     */
    public function setCompetitor($competitor)
    {
        $this->competitor = $competitor;
    }

    /**
     * Getter method for the property.
     *
     * @return Marketplace
     */
    public function getMarketplace()
    {
        return $this->marketplace;
    }

    /**
     * Setter method for the property.
     *
     * @param Marketplace $marketplace
     *
     * @return void
     */
    public function setMarketplace($marketplace)
    {
        $this->marketplace = $marketplace;
    }
}
