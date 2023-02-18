<?php

try {
    $db = new PDO('pgsql:host=localhost;port=5432;dbname=daily', 'postgres', 12136270);
} catch (PDOException $e) {
    echo "Failed to connect to the database: " . $e->getMessage();
}


$db->query("
    CREATE OR REPLACE FUNCTION add(
        a INTEGER,
        b INTEGER)
      RETURNS integer AS $$
    BEGIN
        return a * b;
    END; $$
      LANGUAGE 'plpgsql';
");

$statement = $db->prepare("SELECT add(:a, :b)");

$a = 20;
$b = 100;
$statement->bindValue(':a', $a, PDO::PARAM_INT);
$statement->bindValue(':b', $b, PDO::PARAM_INT);

$statement->execute();

$result = $statement->fetchColumn();

echo "The result of $a * $b is $result";
?>