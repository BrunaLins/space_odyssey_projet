<?php


namespace App\Entity;


class Search
{
    /**
     * @var string|null
     */
    private $destination;

    /**
     * @var string|null
     */
    private $typeHebergement;

    /**
     * @return string|null
     */
    public function getDestination(): ?string
    {
        return $this->destination;
    }

    /**
     * @param string|null $destination
     * @return Search
     */
    public function setDestination(string $destination): Search
    {
        $this->destination = $destination;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTypeHebergement(): ?string
    {
        return $this->typeHebergement;
    }

    /**
     * @param string|null $typeHebergement
     * @return Search
     */
    public function setTypeHebergement(string $typeHebergement): Search
    {
        $this->typeHebergement = $typeHebergement;
        return $this;
    }


}