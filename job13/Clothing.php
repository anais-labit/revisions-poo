<?php

require_once "AbstractProduct.php";

class Clothing extends AbstractProduct
{
    public function __construct(
        private ?int $id = null,
        private ?string $name = null,
        private ?array $photos = null,
        private ?int $price = null,
        private ?string $description = null,
        private ?int $quantity = null,
        private ?DateTime $createdAt = null,
        private ?DateTime $updatedAt = null,
        private ?int $id_category = null,
        private ?string $size = null,
        private ?string $color = null,
        private ?string $type = null,
        private ?int $material_fee = null
    ) {
        parent::__construct($id, $name, $photos, $price, $description, $quantity, $createdAt, $updatedAt, $id_category);
    }

    /**
     * Get the value of size
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set the value of size
     *
     * @return  self
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get the value of color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set the value of color
     *
     * @return  self
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get the value of type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of material_fee
     */
    public function getMaterial_fee()
    {
        return $this->material_fee;
    }

    /**
     * Set the value of material_fee
     *
     * @return  self
     */
    public function setMaterial_fee($material_fee)
    {
        $this->material_fee = $material_fee;

        return $this;
    }

    public static function findOneById(int $id):  Clothing|bool
    {

        $query = "SELECT * FROM clothing INNER JOIN product ON clothing.product_id = product.id WHERE product_id = :id";
        $statement = Database::dbConnexion()->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $photosUrl = json_decode($result['photos'], true);
            $createdAt = new DateTime($result['createdAt']);
            $updatedAt = new DateTime($result['updatedAt']);
            $clothing = new Clothing(
                $result['id'],
                $result['name'],
                $photosUrl,
                $result['price'],
                $result['description'],
                $result['quantity'],
                $createdAt,
                $updatedAt,
                $result['category_id'],
                $result['size'],
                $result['color'],
                $result['type'],
                $result['material_fee']
            );
            return $clothing;
        } else {
            return false;
        }
    }

    public static function findAll(): array|bool
    {
        $query = "SELECT * FROM clothing INNER JOIN product ON clothing.product_id = product.id";
        $statement = Database::dbConnexion()->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $clothings = [];

        foreach ($results as $result) {
            $photosUrl = json_decode($result['photos'], true);
            $createdAt = new DateTime($result['createdAt']);
            $updatedAt =   new DateTime($result['updatedAt']);
            $clothing = new Clothing(
                $result['id'],
                $result['name'],
                $photosUrl,
                $result['price'],
                $result['description'],
                $result['quantity'],
                $createdAt,
                $updatedAt,
                $result['category_id'],
                $result['size'],
                $result['color'],
                $result['type'],
                $result['material_fee']
            );
            $clothings[] = $clothing;
        }
        if ($clothings) {
            return $clothings;
        }
        return false;
    }

    public function create(): Clothing|bool
    {
        $newProduct = parent::create();
        if (!$newProduct) {
            return $newProduct;
        }

        $product_id = $newProduct->getId();

        $query = "INSERT INTO clothing (product_id, size, color, type, material_fee) VALUES (:product_id, :size, :color, :type, :material_fee)";
        $statement = Database::dbConnexion()->prepare($query);

        $newClothing = $statement->execute([
            'product_id' => $product_id,
            'size' => $this->size,
            'color' => $this->color,
            'type' => $this->type,
            'material_fee' => $this->material_fee,
        ]);

        if ($newClothing) {
            return $this;
        }
        return $newClothing;
    }

    public function update(): Clothing|bool
    {
        parent::update();

        $product_id = $this->getId();
        $productInfos = $this->findOneById($product_id);

        var_dump($productInfos);

        if (
            $productInfos->size !== $this->size ||
            $productInfos->color !== $this->color ||
            $productInfos->type !== $this->type ||
            $productInfos->material_fee !== $this->material_fee
        ) {

            $query = "UPDATE clothing SET size = :size, color = :color, type = :type, material_fee = :material_fee WHERE product_id = :product_id";

            $statement = Database::dbConnexion()->prepare($query);

            $success = $statement->execute([
                'product_id' => $product_id,
                ':size' => $this->size,
                ':color' => $this->color,
                ':type' => $this->type,
                ':material_fee' => $this->material_fee,
            ]);

            if ($success) {
                echo 'Vêtement ajouté et mis à jour dans la foulée';
                return $this;
            } else {
                return false;
            }

        }
    }
}
