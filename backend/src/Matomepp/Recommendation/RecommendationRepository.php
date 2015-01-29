<?php

namespace sat8bit\Matomepp\Recommendation;

use PDO;

class RecommendationRepository
{
    /**
     * @var PDO
     */
    protected $pdo;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param string $keyword
     * @return Recommendation
     */
    public function find($keyword)
    {
        $stmt = $this->pdo->prepare("
            SELECT
                keyword
            FROM
                recommendations
            WHERE
                keyword = :keyword
        ");

        $stmt->bindValue(':keyword', $keyword, PDO::PARAM_STR);
        $stmt->execute();

        if($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return new Recommendation($keyword);
        }

        return null;
    }

    /**
     * @param Recommendation $recommendation
     */
    public function store(Recommendation $recommendation)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO recommendations(
                keyword
            )
            VALUES(
                :keyword
            )
        ");

        $stmt->bindValue(':keyword', $recommendation->getKeyword(), PDO::PARAM_STR);
        $stmt->execute();
    }
}
