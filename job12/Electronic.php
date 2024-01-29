<?php

require_once "Product.php";

class Electronic extends Product

{
    public function __construct(
        protected ?int $id = null,
        protected ?string $name = null,
        protected ?array $photos = null,
        protected ?int $price = null,
        protected ?string $description = null,
        protected ?int $quantity = null,
        protected ?DateTime $createdAt = null,
        protected ?DateTime $updatedAt = null,
        protected ?int $id_category = null,
        protected ?string $brand = null,
        protected ?int $waranty_fee = null
    ) {
        parent::__construct($id, $name, $photos, $price, $description, $quantity, $createdAt, $updatedAt, $id_category);
    }

    /**
     * Get the value of brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set the value of brand
     *
     * @return  self
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get the value of waranty_fee
     */
    public function getWaranty_fee()
    {
        return $this->waranty_fee;
    }

    /**
     * Set the value of waranty_fee
     *
     * @return  self
     */
    public function setWaranty_fee($waranty_fee)
    {
        $this->waranty_fee = $waranty_fee;

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

    public function findOneById(int $id): Electronic|bool
    {

        $query = "SELECT * FROM electronic INNER JOIN product ON electronic.product_id = product.id WHERE product_id = :id";
        $dbConn = $this->dbConnexion();
        $statement = $dbConn->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $photosUrl = json_decode($result['photos'], true);
            $createdAt = new DateTime($result['createdAt']);
            $updatedAt = new DateTime($result['updatedAt']);
            $electronic = new Electronic(
                $result['id'],
                $result['name'],
                $photosUrl,
                $result['price'],
                $result['description'],
                $result['quantity'],
                $createdAt,
                $updatedAt,
                $result['category_id'],
                $result['brand'],
                $result['waranty_fee'],
            );
            return $electronic;
        } else {
            return false;
        }
    }

    public function findAll(): array|bool
    {
        $query = "SELECT * FROM electronic INNER JOIN product ON electronic.product_id = product.id";
        $dbConn = $this->dbConnexion();
        $statement = $dbConn->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $electronics = [];

        foreach ($results as $result) {
            $photosUrl = json_decode($result['photos'], true);
            $createdAt = new DateTime($result['createdAt']);
            $updatedAt =   new DateTime($result['updatedAt']);
            $electronic = new Electronic(
                $result['id'],
                $result['name'],
                $photosUrl,
                $result['price'],
                $result['description'],
                $result['quantity'],
                $createdAt,
                $updatedAt,
                $result['category_id'],
                $result['brand'],
                $result['waranty_fee'],
            );
            $electronics[] = $electronic;
        }
        if ($electronics) {
            return $electronics;
        }
        return false;
    }

    public function create(): Electronic|bool
    {
        $newProduct = parent::create();
        if (!$newProduct) {
            return $newProduct;
        }

        $product_id = $newProduct->getId();

        $query = "INSERT INTO electronic (product_id, brand, waranty_fee) VALUES (:product_id, :brand, :waranty_fee)";
        $dbConn = $this->dbConnexion();
        $statement = $dbConn->prepare($query);

        $newelectronic = $statement->execute([
            'product_id' => $product_id,
            'brand' => $this->brand,
            'waranty_fee' => $this->waranty_fee,
        ]);

        if ($newelectronic) {
            return $this;
        }
        return $newelectronic;
    }

    public function update(): Electronic|bool
    {
        $product_id = $this->getId();
        $productInfos = $this->findOneById($product_id);

        if (
            $productInfos->brand !== $this->brand ||
            $productInfos->waranty_fee !== $this->waranty_fee
        ) {

            $query = "UPDATE electronic SET brand = :brand, waranty_fee = :waranty_fee WHERE product_id = :product_id";

            $dbConn = $this->dbConnexion();
            $statement = $dbConn->prepare($query);

            $success = $statement->execute([
                'product_id' => $product_id,
                ':brand' => $this->brand,
                ':waranty_fee' => $this->waranty_fee,
            ]);

            if ($success) {
                echo 'Electronic ajouté et mis à jour dans la foulée';
                return $this;
            } else {
                return false;
            }
        }
    }

}
