<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use App\Entity\Categories;
use App\Entity\Comments;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //5 categories
        for ($i=1; $i <= 5 ; $i++) { 
            $category = new Categories;
            $category->setName("Categorie $i");

            $manager->persist($category);
            $categories[] = $category;
        }


        //1 User
        $user = new Users;
        $user->setUsername('testUser');
        $user->setPassword(password_hash('password', PASSWORD_DEFAULT));

        $manager->persist($user);



        //5 articles avec 5 comentaires
        for ($i=1; $i <= 5 ; $i++) { 
            $article = new Articles();
            $article->setTitle("Article $i");
            $article->setContent("Contenu de l'article $i");
            $article->setUser($user);
            $article->setCategory($categories[array_rand($categories)]);

            $manager->persist($article);

            for ($j=1; $j <= 5 ; $j++) { 
                $comment = new Comments;
                $comment->setContent("Commentaire $j pour l'article $i");
                $comment->setUser($user);
                $comment->setArticle($article);

                $manager->persist($comment);
            }
        }


        
        $manager->flush();
    }
}
