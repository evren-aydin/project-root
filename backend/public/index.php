<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use App\Database;
use Services\DataLoad;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();


$app->get('/api/load-users', function (Request $request, Response $response) {
    $database = new Database();
    $pdo = $database->getConnection();

    $dataLoader = new DataLoad($pdo); // DataLoad sınıfını oluştur
    $dataLoader->loadUsers(); // Kullanıcıları yükle

    $response->getBody()->write(json_encode(['message' => 'Users loaded successfully']));
    return $response->withHeader('Content-Type', 'application/json');
});
$app->get('/api/load-posts', function (Request $request, Response $response) {
    $database = new Database();
    $pdo = $database->getConnection();

    $dataLoader = new DataLoad($pdo); // DataLoad sınıfını oluştur
    $dataLoader->loadPosts(); // Kullanıcıları yükle

    $response->getBody()->write(json_encode(['message' => 'Posts loaded successfully']));
    return $response->withHeader('Content-Type', 'application/json');
});

// Veritabanındaki kullanıcıları döndüren endpoint
$app->get('/api/users', function (Request $request, Response $response) {
    $database = new Database();
    $pdo = $database->getConnection();
    $stmt = $pdo->query('SELECT * FROM users');
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $body = json_encode($data);
    $response->getBody()->write($body);

    return $response->withHeader('Content-Type', 'application/json');
});
$app->get('/api/posts', function (Request $request, Response $response) {
    $database = new Database();
    $pdo = $database->getConnection();
    $stmt = $pdo->query('SELECT * FROM posts');
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $body = json_encode($data);
    $response->getBody()->write($body);

    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
