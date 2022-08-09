<?php

namespace App\Entity;

use App\Doctrine\Attributes\Serializable;
use App\Model\DentalData;
use App\Repository\DentalDiagramRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Validator\DentalDiagram as DentalDiagramConstraint;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DentalDiagramRepository::class)]
#[DentalDiagramConstraint]
class DentalDiagram
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

//    #[ORM\Column(type: 'json')]
    #[ORM\Column]
    #[Serializable(targetProperty: 'datas', class: DentalData::class, collection: true, groups: 'Bar')]
    private array $jsonDatas = [];

    /** @var array<DentalData> */
    #[Assert\Valid]
    private array $datas = [];

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get raw PHP array data from JSON in database.
     * (Doctrine handle)
     *
     * @internal
     */
    public function getJsonDatas(): array
    {
        return $this->jsonDatas;
    }

    /**
     * Set raw PHP array data for JSON in database.
     *
     * @internal
     */
    public function setJsonDatas(array $jsonDatas): static
    {
        $this->jsonDatas = $jsonDatas;

        return $this;
    }

    /** @return array<DentalData> */
    public function getDatas(): array
    {
        return $this->datas;
    }

    /** @param array<DentalData> $datas */
    public function setDatas(array $datas): static
    {
        $this->datas = $datas;
        $this->triggerDoctrine();

        return $this;
    }

    public function addData(DentalData $data): static
    {
        if (!in_array($data, $this->datas)) {
            $this->datas[] = $data;
            $this->triggerDoctrine();
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    private function triggerDoctrine(): void
    {
        $this->setUpdatedAt(new \DateTimeImmutable());
    }
}
