<?php

require_once 'Product.php';

class Category
{
    private ?int $id;
    private ?string $name;
    private ?string $description;
    private ?DateTime $createdAt;
    private ?DateTime $updatedAt;

    public function __construct(int $id = null, string $name = null, string $description = null, DateTime $createdAt = null, DateTime $updatedAt = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public static function dbConnexion(): PDO
    {
        $dbConn = new PDO(
            "mysql:host=localhost;dbname=draft-shop",
            "anais",
            ""
        );
        return $dbConn;
    }

    public function getProducts(): array
    {
        $dbConn = $this->dbConnexion();
        $query = "SELECT * FROM product WHERE category_id = :category_id";

        $statement = $dbConn->prepare($query);
        $statement->bindValue(':category_id', $this->id);

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $products = [];
        foreach ($results as $result) {
            $createdAt = new DateTime($result['createdAt']);
            $updatedAt = new DateTime($result['updatedAt']);
            $product = new Product(
                $result['id'],
                $result['name'],
                json_decode($result['photos'], true),
                $result['price'],
                $result['description'],
                $result['quantity'],
                $createdAt,
                $updatedAt,
                $result['category_id']
            );
            $products[] = $product;
        }
        return $products;
    }
}
