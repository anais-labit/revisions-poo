<?php

require_once 'Category.php';
class Product
{
    private ?int $id;
    private ?string $name;
    private ?array $photos;
    private ?int $price;
    private ?string $description;
    private ?int $quantity;
    private ?DateTime $createdAt;
    private ?DateTime $updatedAt;
    private ?int $category_id;

    public function __construct(int $id = null, string $name = null, array $photos = null, int $price = null, string $description = null, int $quantity = null, DateTime $createdAt = null, DateTime $updatedAt = null, int $category_id = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->photos = $photos;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->category_id = $category_id;
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

    public function getPhotos(): ?array
    {
        return $this->photos;
    }

    public function setPhotos(?array $photos): self
    {
        $this->photos = $photos;
        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;
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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;
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

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function setCategoryId(?int $category_id): self
    {
        $this->category_id = $category_id;
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

    public function getCategory(): Category
    {
        $query = "SELECT * FROM category WHERE id = :id";
        $dbConn = $this->dbConnexion();

        $statement = $dbConn->prepare($query);
        $statement->bindValue(':id', $this->category_id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        $createdAt = new DateTime($result['createdAt']);
        $updatedAt = new DateTime($result['updatedAt']);

        $category = new Category($result['id'], $result['name'], $result['description'], $createdAt, $updatedAt);
        return $category;
    }

    public function findOneById(int $id): bool|Product
    {
        $query = "SELECT * FROM product WHERE id = :id";
        $dbConn = $this->dbConnexion();
        $statement = $dbConn->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $photosUrl = json_decode($result['photos'], true);
            $createdAt = new DateTime($result['createdAt']);
            $updatedAt = new DateTime($result['updatedAt']);
            $product = new Product(
                $result['id'],
                $result['name'],
                $photosUrl,
                $result['price'],
                $result['description'],
                $result['quantity'],
                $createdAt,
                $updatedAt,
                $result['category_id']
            );
            return $product;
        }
        return false;
    }

    public function findAll(): array|bool
    {
        $query = "SELECT * FROM product";
        $dbConn = $this->dbConnexion();
        $statement = $dbConn->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $products = [];

        foreach ($results as $result) {
            $photosUrl = json_decode($result['photos'], true);
            $createdAt = new DateTime($result['createdAt']);
            $updatedAt = new DateTime($result['updatedAt']);
            $product = new Product($result['id'], $result['name'], $photosUrl, $result['price'], $result['description'], $result['quantity'], $createdAt, $updatedAt, $result['category_id']);

            $products[] = $product;
        }
        if ($products) {
            return $products;
        }
        return false;
    }

    public function create(): Product|bool
    {
        $query = "INSERT INTO product(name, photos, price, description, quantity, createdAt, category_id) VALUES (:name, :photos, :price, :description, :quantity, :createdAt, :category_id) ";
        $dbConn = $this->dbConnexion();
        $statement = $dbConn->prepare($query);

        $newProduct = $statement->execute([
            ':name' => $this->name,
            ':photos' => json_encode($this->photos),
            ':price' => $this->price,
            ':description' => $this->description,
            ':quantity' => $this->quantity,
            ':createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            ':category_id' => $this->category_id
        ]);

        if ($newProduct) {
            $lastInsertId = $dbConn->lastInsertId();
            $this->setId($lastInsertId);
            return $this;
        } else {
            return false;
        }
    }

    public function update(): Product|bool
    {
        $product_id = $this->id;
        $productInfos = $this->findOneById($product_id);

        if (
            $productInfos->name !== $this->name ||
            $productInfos->photos !== $this->photos ||
            $productInfos->price !== $this->price ||
            $productInfos->description !== $this->description ||
            $productInfos->quantity !== $this->quantity
        ) {

            $query = "UPDATE product SET name = :name, photos = :photos, price = :price, description = :description, quantity = :quantity, updatedAt = :updatedAt, category_id = :category_id WHERE id = :id";

            $dbConn = $this->dbConnexion();
            $statement = $dbConn->prepare($query);

            $success = $statement->execute([
                'id' => $product_id,
                ':name' => ($this->name),
                ':photos' => json_encode($this->photos),
                ':price' => $this->price,
                ':description' => $this->description,
                ':quantity' => $this->quantity,
                ':updatedAt' => (new DateTime())->format('Y-m-d H:i:s'),
                ':category_id' => $this->category_id,
            ]);

            if ($success) {
                echo 'Produit ajouté et mis à jour dans la foulée';
                return $this;
            } else {
                return false;
            }
        }
    }
}
