<?php
namespace App\Core;

use PDO;
use Exception;
use PDOException;
use App\Post\PostsRepository;
use App\Post\CommentsRepository;
use App\Post\PostsController;


class Container
{

  private $receipts = [];
  private $instances = [];

  public function __construct()
  {
    $this->receipts = [
      'postsController' => function()
      {
        return new PostsController(
          $this->make('postsRepository'),
          $this->make('commentsRepository')
        );
      },
      'postsRepository' => function()
      {
        return new PostsRepository(
          $this->make("pdo")
        );
      },
      'commentsRepository' => function()
      {
        return new CommentsRepository(
          $this->make("pdo")
        );
      },
      'pdo' => function()
      {
        try {
          $pdo = new PDO(
            'mysql:host=localhost;dbname=blog;charset=utf8',
            'blog',
            'FRrHpLeFDzcvmStV'
          );
        } catch (PDOException $e) {
          echo "Verbindung zur Datenbank fehlgeschlagen";
          die();
        }
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);  //Sonderfall einer MySQL injection. Wichtig
        return $pdo;
      }
    ];
  }

  public function make($name)
  {
    if (!empty($this->instances[$name]))
    {
      return $this->instances[$name];
    }

    if (isset($this->receipts[$name]))
    {
      $this->instances[$name] = $this->receipts[$name]();
    }

    // ERZEUGE: $this->instances[$name]
    return $this->instances[$name];
  }
  /*
  private $pdo;
  private $postsRepository;

  public function getPdo()
  {
  if(!empty($this->pdo)) {
  return $this->pdo;
}
return $this->pdo;
}
public function getPostsRepository()
{
if(!empty($this->postsRepository)) {
return $this->postsRepository;
}
$this->postsRepository = new PostsRepository(
$this->getPdo()
);
return $this->postsRepository;
}
*/
}

?>
