<?php 
namespace App\Entity;

class Origine{

    private int $id;
    private string $origineLabel;


    public function __construct(array $data = [])
    {
        foreach ($data as $propertyName => $value) {
            $setter = 'set' . ucfirst($propertyName);
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }
    }

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of origine_label
     */
    public function getOrigineLabel(): string
    {
        return $this->origineLabel;
    }

    /**
     * Set the value of origine_label
     */
    public function setOrigineLabel(string $origineLabel): self
    {
        $this->origineLabel = $origineLabel;

        return $this;
    }
    }
    