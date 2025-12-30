<?php

namespace App\Entity;

use App\Repository\VisitorInformationRepository;
use Doctrine\ORM\Mapping as ORM;
use Marbobley\EntitiesVisitorBundle\Model\VisitorInformation as VisitorInformationModel;

#[ORM\Entity(repositoryClass: VisitorInformationRepository::class)]
class VisitorInformation extends VisitorInformationModel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
