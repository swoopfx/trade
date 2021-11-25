<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ZoneToGeoZone
 *
 * @ORM\Table(name="zone_to_geo_zone")
 * @ORM\Entity
 */
class ZoneToGeoZone
{
    /**
     * @var int
     *
     * @ORM\Column(name="zone_to_geo_zone_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $zoneToGeoZoneId;

    /**
     * @var int
     *
     * @ORM\Column(name="country_id", type="integer", nullable=false)
     */
    private $countryId;

    /**
     * @var int
     *
     * @ORM\Column(name="zone_id", type="integer", nullable=false)
     */
    private $zoneId = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="geo_zone_id", type="integer", nullable=false)
     */
    private $geoZoneId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_added", type="datetime", nullable=false)
     */
    private $dateAdded;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modified", type="datetime", nullable=false)
     */
    private $dateModified;


}
