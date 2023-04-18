<?php 


namespace App\Entity;

class Interest {

    private int $id;
    private string $interest_label;


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
     * Get the value of interest_label
     */
    public function getInterestLabel(): string
    {
        return $this->interest_label;
    }

    /**
     * Set the value of interest_label
     */
    public function setInterest_label(string $interest_label): self
    {
        $this->interest_label = $interest_label;

        return $this;
    }
    }
    