<?php

namespace App\Entity;

use App\Repository\MicroServiceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MicroServiceRepository::class)]
class MicroService
{

    const GROUPES = [
        "Les 2 de devant" => "Les 2 de devant",
        "UwU" => "UwU",
        "Le groupe de Mohamed" => "Le groupe de Mohamed",
        "Le groupe de Mehdi" => "Le groupe de Mehdi",
        "RXnMore" => "RXnMore",
        "Le groupe du fond" => "Le groupe du fond",
        "Le groupe de 2 #1" => "Le groupe de 2 #1",
        "Les 2 autres de devant" => "Les 2 autres de devant",
        "Le prof" => "Le prof",
    ];

    const SERVICES = [
        "BDD Film" => "BDD Film",
        "BDD Comms" => "BDD Comms",
        "Fournisseur" => "Fournisseur",
        "Vitrine" => "Vitrine",
        "Modération" => "Modération",
        "Email" => "Email",
        "Log" => "Log",
        "Images" => "Images",
        "Vidéos" => "Vidéos",
        "Annuaire" => "Annuaire",
        "Autre" => "Autre",
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    public $id;

    public function __construct(

    #[ORM\Column(type: 'string', length: 255)]
    public ?string $groupe = null,

    #[ORM\Column(type: 'string', length: 255)]
    public ?string $service = null,

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public ?string $git = null,

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public ?string $host = null,

    #[ORM\Column(type: 'integer', nullable: true)]
    public ?int $port = 80,

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public ?string $urlPing = null,

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public ?string $urlHome = null,

    #[ORM\Column(type: 'integer', nullable: true)]
    public ?int $ping = null,

    ) {}

    public function getUrl()
    {
        return $this->host . ':' . $this->port;
    }

    public function getUrlToPing()
    {
        return $this->getUrl() . $this->urlPing;
    }

    public function getUrlToHome(): ?string
    {
        return $this->urlHome
            ? $this->getUrl() . $this->urlHome
            : null;
    }

    public function __toString(): string
    {
        return $this->service . " [#".$this->id."]";
    }

}
