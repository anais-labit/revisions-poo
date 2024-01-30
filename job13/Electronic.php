<?php

require_once "AbstractProduct.php";

class Electronic extends AbstractProduct

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
        protected ?int $warranty_fee = null
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
     * Get the value of warranty_fee
     */
    public function getWarranty_fee()
    {
        return $this->warranty_fee;
    }

    /**
     * Set the value of warranty_fee
     *
     * @return  self
     */
    public function setWarranty_fee($warranty_fee)
    {
        $this->warranty_fee = $warranty_fee;

        return $this;
    }

    public static function findOneById(int $id): Electronic|bool
    {

        $query = "SELECT * FROM electronic INNER JOIN product ON electronic.product_id = product.id WHERE product_id = :id";
        $statement = Database::dbConnexion()->prepare($query);
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
                $result['warranty_fee'],
            );
            return $electronic;
        } else {
            return false;
        }
    }

    public static function findAll(): array|bool
    {
        $query = "SELECT * FROM electronic INNER JOIN product ON electronic.product_id = product.id";
        $statement = Database::dbConnexion()->prepare($query);
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
                $result['warranty_fee'],
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
            return false;
        }

        $product_id = $newProduct->getId();

        $query = "INSERT INTO electronic (product_id, brand, warranty_fee) VALUES (:product_id, :brand, :warranty_fee)";
        $statement = Database::dbConnexion()->prepare($query);

        $newElectronic = $statement->execute([
            'product_id' => $product_id,
            'brand' => $this->brand,
            'warranty_fee' => $this->warranty_fee,
        ]);

        if ($newElectronic) {
            return $this;
        }
        return $newElectronic;
    }

    public function update(): Electronic
    {
        parent::update();

        $query = "UPDATE electronic SET brand = :brand, warranty_fee = :warranty_fee WHERE product_id = :product_id";
        $statement = Database::dbConnexion()->prepare($query);

        $updatedElectronic = $statement->execute([
            'product_id' => $this->getId(),
            'brand' => $this->brand,
            'warranty_fee' => $this->warranty_fee,
        ]);

        if ($updatedElectronic) {
            echo 'Electronic ajouté et mis à jour dans la foulée';
            return $this;
        }
        return false;
    }
}
